// ============================================================
//  AUTHENTICATION - Updated for Database Integration
// ============================================================

let currentUser = null;
let employees = [];
let inventoryItems = [];
let restockRecords = [];
let suppliers = [];
let leaveRequests = [];
let onlineOrders = [];
let inStoreOrders = [];
let customCakeOrders = [];
let customCakeRequests = [];
let customers = [];
let stockAlerts = [];
let instoreCart = [];
let inStoreOrderCounter = 1;
let customCakeCounter = 1;

function handleLogout() {
    currentUser = null;
    localStorage.removeItem('peoplesBakersUser');
    document.getElementById('app').style.display = 'none';
    document.getElementById('loginPage').style.display = 'flex';
    document.getElementById('loginForm').reset();
    document.getElementById('loginError').style.display = 'none';
}

async function loadAppData() {
    try {
        if (typeof InventoryAPI !== 'undefined') {
            const inventoryResponse = await InventoryAPI.list();
            if (inventoryResponse.success) {
                inventoryItems = (inventoryResponse.data || []).map(item => ({
                    ...item,
                    product_id: item.product_id || item.id,
                    name: item.name || '',
                    price: Number(item.price || 0),
                    stock: Number(item.stock_qty || item.stock || 0),
                    stock_qty: Number(item.stock_qty || item.stock || 0),
                    category: item.category_name || item.category || 'General',
                    category_id: item.category_id || null,
                }));
            }

            const alertsResponse = await InventoryAPI.alerts();
            if (alertsResponse.success) {
                stockAlerts = alertsResponse.data || [];
            }
        }

        if (typeof RestockAPI !== 'undefined') {
            const restockResponse = await RestockAPI.list();
            if (restockResponse.success) {
                restockRecords = (restockResponse.data || []).map(record => ({
                    ...record,
                    id: record.restock_id || record.id,
                    product_id: record.product_id || null,
                    supplier_id: record.supplier_id || null,
                    item: record.product_name || record.item || '',
                    supplier: record.supplier_name || record.supplier || '',
                    qty: Number(record.quantity || record.qty || 0),
                    unitCost: Number(record.unit_cost || record.unitCost || 0),
                    date: record.restock_date || record.date || '',
                    notes: record.notes || '',
                }));
            }

            const suppliersResponse = await RestockAPI.suppliers();
            if (suppliersResponse.success) {
                suppliers = suppliersResponse.data || [];
            }
        }

        if (typeof EmployeeAPI !== 'undefined') {
            const employeesResponse = await EmployeeAPI.list();
            if (employeesResponse.success) {
                employees = (employeesResponse.data || []).map(employee => ({
                    ...employee,
                    id: employee.employee_id || employee.id,
                    employee_id: employee.employee_id || employee.id,
                    name: employee.name || '',
                    username: employee.username || ''
                }));
            }
        }

        if (typeof LeaveAPI !== 'undefined') {
            const leaveResponse = await LeaveAPI.list();
            if (leaveResponse.success) {
                leaveRequests = leaveResponse.data || [];
            }
        }

        if (typeof OrdersAPI !== 'undefined') {
            const ordersResponse = await OrdersAPI.list('all');
            if (ordersResponse.success) {
                const orders = (ordersResponse.data || []).map(order => ({
                    ...order,
                    id: order.order_id || order.id,
                    customer: order.customer_name || order.customer || 'Guest Customer',
                    total: Number(order.total_amount || order.total || 0),
                    status: order.status || 'Pending',
                    date: order.order_date || order.date || '',
                    order_type: order.order_type || order.type || '',
                    items: Array.isArray(order.items) ? order.items.map(item => ({
                        ...item,
                        name: item.product_name || item.name || '',
                        qty: Number(item.quantity || item.qty || 0),
                        price: Number(item.price_at_time || item.price || 0),
                    })) : []
                }));

                onlineOrders = orders.filter(order => (order.order_type || '').toLowerCase() === 'online');
                inStoreOrders = orders.filter(order => (order.order_type || '').toLowerCase() === 'instore');
                customCakeRequests = orders.filter(order => (order.order_type || '').toLowerCase() === 'custom').map(order => ({
                    ...order,
                    customer: order.customer_name || order.customer || 'Guest Customer',
                    design: order.design_details || order.description || 'Custom cake request',
                    phone: order.phone || 'N/A',
                    description: order.description || order.design_details || 'No description provided',
                    date: order.date || order.order_date || ''
                }));
                customCakeCounter = Math.max(1, customCakeRequests.length + 1);
                inStoreOrderCounter = Math.max(1, inStoreOrders.length + 1);
            }
        }
    } catch (error) {
        console.error('Failed to load app data:', error);
    }
}

document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const username = document.getElementById('loginUsername').value.trim();
    const password = document.getElementById('loginPassword').value.trim();
    const errorEl = document.getElementById('loginError');

    try {
        const response = await EmployeeAPI.login(username, password);

        if (!response.success) {
            errorEl.style.display = 'block';
            errorEl.textContent = response.message || 'Invalid username or password';
            return;
        }

        errorEl.style.display = 'none';
        currentUser = response.data;

        const roleMap = {
            'salesassistant': 'Sales Assistant',
            'deliveryemployee': 'Delivery Employee',
            'inventorymanager': 'Inventory Manager',
            'employeemanager': 'Employee Manager',
            'companymanager': 'Company Manager',
            'financemanager': 'Finance Manager',
            'salessupervisor': 'Sales Supervisor'
        };
        currentUser.displayRole = roleMap[currentUser.role] || currentUser.role;

        localStorage.setItem('peoplesBakersUser', JSON.stringify(currentUser));

        document.getElementById('loginPage').style.display = 'none';
        document.getElementById('app').style.display = 'flex';
        await loadAppData();
        renderApp();
    } catch (error) {
        errorEl.style.display = 'block';
        errorEl.textContent = 'Network error: ' + error.message;
    }
});

const savedUser = localStorage.getItem('peoplesBakersUser');
if (savedUser) {
    try {
        currentUser = JSON.parse(savedUser);
        document.getElementById('loginPage').style.display = 'none';
        document.getElementById('app').style.display = 'flex';
        loadAppData().then(() => renderApp());
    } catch (e) {
        localStorage.removeItem('peoplesBakersUser');
        document.getElementById('loginPage').style.display = 'flex';
        document.getElementById('app').style.display = 'none';
    }
} else {
    document.getElementById('loginPage').style.display = 'flex';
    document.getElementById('app').style.display = 'none';
}

document.getElementById('logoutFromProfile').addEventListener('click', function() {
    document.getElementById('profileMenu').classList.remove('active');
    handleLogout();
});