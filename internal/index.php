
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Peoples Bakers - Complete System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>

  <!-- LOGIN PAGE -->
  <div id="loginPage">
    <div class="login-card">
      <div class="logo">
        <svg viewBox="0 0 60 60" fill="none" width="48" height="48">
          <rect x="4" y="10" width="52" height="40" rx="10" fill="#6b3fa0" />
          <path d="M18 28L24 20L30 28L36 20L42 28" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
          <circle cx="24" cy="38" r="4" fill="#f9c80e" />
          <circle cx="36" cy="38" r="4" fill="#f9c80e" />
          <rect x="8" y="8" width="44" height="6" rx="3" fill="#f9c80e" />
        </svg>
        <h1>Peoples<span>Bakers</span></h1>
        <p style="color:var(--text-gray);font-size:0.85rem;margin-top:0.2rem;">Employee Login</p>
      </div>
      <form id="loginForm">
        <div class="form-group">
          <label><i class="fas fa-user"></i> Username</label>
          <input type="text" id="loginUsername" placeholder="Enter your username" required />
        </div>
        <div class="form-group">
          <label><i class="fas fa-lock"></i> Password</label>
          <input type="password" id="loginPassword" placeholder="Enter your password" required />
        </div>
        <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Sign In</button>
        <div id="loginError" class="login-error">Invalid username or password</div>
      </form>
      <div class="login-hint">
        <strong>Sign in with your employee account.</strong><br />
        <span style="display:block;font-size:0.75rem;margin-top:0.3rem;color:var(--text-gray);">Use the username and password assigned to your role in the database.</span>
      </div>
    </div>
  </div>

  <!-- APP -->
  <div id="app">
    <header class="app-header">
      <div class="brand">
        <svg viewBox="0 0 60 60" fill="none" width="32" height="32">
          <rect x="4" y="10" width="52" height="40" rx="10" fill="#6b3fa0" />
          <path d="M18 28L24 20L30 28L36 20L42 28" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
          <circle cx="24" cy="38" r="4" fill="#f9c80e" />
          <circle cx="36" cy="38" r="4" fill="#f9c80e" />
          <rect x="8" y="8" width="44" height="6" rx="3" fill="#f9c80e" />
        </svg>
        <span>Peoples<span>Bakers</span></span>
      </div>
      <div class="user-info">
        <span id="userNameDisplay" style="font-weight:500;">Loading user...</span>
        <span class="role-badge" id="userRoleDisplay">Employee</span>
        
        <div class="profile-dropdown">
          <button class="profile-btn" id="profileBtn">
            <i class="fas fa-user-circle"></i>
            <i class="fas fa-chevron-down" style="font-size:0.6rem;color:var(--text-gray);"></i>
          </button>
          <div class="profile-dropdown-menu" id="profileMenu">
            <button class="menu-item" data-page="profile-dashboard"><i class="fas fa-id-card"></i> Profile Dashboard</button>
            <button class="menu-item" data-page="my-profile"><i class="fas fa-user"></i> My Profile</button>
            <button class="menu-item" data-page="change-password"><i class="fas fa-key"></i> Change Password</button>
            <button class="menu-item" data-page="leave-request"><i class="fas fa-paper-plane"></i> Leave Request</button>
            <button class="menu-item" data-page="leave-status"><i class="fas fa-clipboard-list"></i> Leave Status</button>
            <div class="menu-divider"></div>
            <button class="menu-item" id="logoutFromProfile"><i class="fas fa-sign-out-alt" style="color:var(--red);"></i> Logout</button>
          </div>
        </div>
      </div>
    </header>

    <div class="app-body">
      <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu" id="sidebarMenu"></ul>
      </aside>

      <main class="main-content" id="mainContent">
        <div class="page-title" id="pageTitle">Dashboard</div>
        <div id="pageContent"></div>
      </main>
    </div>
  </div>

  <!-- ============================================================ -->
  <!-- MODALS -->
  <!-- ============================================================ -->

  <!-- MODAL: Add New Item -->
  <div class="modal-overlay" id="addItemModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3><i class="fas fa-plus-circle" style="color:var(--primary);margin-right:0.5rem;"></i> Add New Inventory Item</h3>
        <button class="modal-close" id="closeAddItemModal">&times;</button>
      </div>
      <form id="addItemForm">
        <div class="form-group">
          <label>Item Name <span style="color:var(--danger);">*</span></label>
          <input type="text" id="newItemName" placeholder="e.g. Whole Wheat Bread" required />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Price ($) <span style="color:var(--danger);">*</span></label>
            <input type="number" id="newItemPrice" placeholder="0.00" min="0.01" step="0.01" required />
          </div>
          <div class="form-group">
            <label>Initial Stock <span style="color:var(--danger);">*</span></label>
            <input type="number" id="newItemStock" placeholder="0" min="0" required />
          </div>
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Add Item</button>
          <button type="button" class="btn btn-outline" id="cancelAddItemBtn">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL: Adjust Quantity / Price -->
  <div class="modal-overlay" id="editItemModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3><i class="fas fa-pen" style="color:var(--primary);margin-right:0.5rem;"></i> Adjust Item</h3>
        <button class="modal-close" id="closeEditItemModal">&times;</button>
      </div>
      <form id="editItemForm">
        <div class="form-group">
          <label>Item</label>
          <input type="text" id="editItemName" disabled style="background:#f0ebf7;color:#555;" />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>New Price ($)</label>
            <input type="number" id="editItemPrice" min="0.01" step="0.01" required />
          </div>
          <div class="form-group">
            <label>New Quantity</label>
            <input type="number" id="editItemStock" min="0" required />
          </div>
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Item</button>
          <button type="button" class="btn btn-outline" id="cancelEditItemBtn">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL: Order Details -->
  <div class="modal-overlay" id="orderDetailsModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3><i class="fas fa-file-invoice" style="color:var(--primary);margin-right:0.5rem;"></i> Order Details</h3>
        <button class="modal-close" id="closeOrderDetailsModal">&times;</button>
      </div>
      <div id="orderDetailsContent">
        <div class="form-group"><label>Order ID</label><input id="detailOrderId" disabled /></div>
        <div class="form-row">
          <div class="form-group"><label>Customer</label><input id="detailCustomer" disabled /></div>
          <div class="form-group"><label>Status</label><input id="detailStatus" disabled /></div>
        </div>
        <div class="form-group"><label>Items</label><textarea id="detailItems" disabled rows="4"></textarea></div>
        <div class="form-group"><label>Total</label><input id="detailTotal" disabled /></div>
      </div>
    </div>
  </div>

  <!-- MODAL: View Restock -->
  <div class="modal-overlay" id="viewRestockModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3><i class="fas fa-eye" style="color:var(--primary);margin-right:0.5rem;"></i> Restock Details</h3>
        <button class="modal-close" id="closeViewRestockModal">&times;</button>
      </div>
      <div id="viewRestockContent"></div>
    </div>
  </div>

  <!-- MODAL: Edit Restock -->
  <div class="modal-overlay" id="editRestockModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3><i class="fas fa-edit" style="color:var(--primary);margin-right:0.5rem;"></i> Edit Restock</h3>
        <button class="modal-close" id="closeEditRestockModal">&times;</button>
      </div>
      <form id="editRestockForm">
        <div class="form-row">
          <div class="form-group">
            <label>Restock ID</label>
            <input id="editRestockId" disabled style="background:#f0ebf7;color:#555;" />
          </div>
          <div class="form-group">
            <label>Item</label>
            <input id="editRestockItem" disabled style="background:#f0ebf7;color:#555;" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Supplier</label>
            <input id="editRestockSupplier" />
          </div>
          <div class="form-group">
            <label>Quantity</label>
            <input type="number" id="editRestockQty" min="1" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Unit Cost ($)</label>
            <input type="number" id="editRestockUnitCost" min="0.01" step="0.01" />
          </div>
          <div class="form-group">
            <label>Date</label>
            <input type="date" id="editRestockDate" />
          </div>
        </div>
        <div class="form-group">
          <label>Notes</label>
          <textarea id="editRestockNotes" rows="3"></textarea>
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Restock</button>
          <button type="button" class="btn btn-outline" id="cancelEditRestockBtn">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL: View Custom Cake -->
  <div class="modal-overlay" id="viewCakeModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3><i class="fas fa-cake" style="color:var(--primary);margin-right:0.5rem;"></i> Custom Cake Details</h3>
        <button class="modal-close" id="closeViewCakeModal">&times;</button>
      </div>
      <div id="viewCakeContent"></div>
    </div>
  </div>

  <!-- MODAL: Restock -->
  <div class="modal-overlay" id="restockModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3><i class="fas fa-archive" style="color:var(--primary);margin-right:0.5rem;"></i> Record Restock</h3>
        <button class="modal-close" id="closeRestockModalBtn">&times;</button>
      </div>
      <form id="restockForm">
        <div class="form-row">
          <div class="form-group">
            <label>Restock ID</label>
            <input id="restockId" disabled style="background:#f0ebf7;color:#555;">
          </div>
          <div class="form-group">
            <label>Item <span style="color:var(--danger);">*</span></label>
            <select id="restockItem" required>
              <option value="">Select item</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Supplier <span style="color:var(--danger);">*</span></label>
            <select id="restockSupplier" required>
              <option value="">Select supplier</option>
              <option value="Bakery Supply Co.">Bakery Supply Co.</option>
              <option value="Dairy Distributors">Dairy Distributors</option>
              <option value="Grain & Mill">Grain & Mill</option>
              <option value="Sweet Ingredients">Sweet Ingredients</option>
            </select>
          </div>
          <div class="form-group">
            <label>Quantity Received <span style="color:var(--danger);">*</span></label>
            <input type="number" id="restockQty" placeholder="e.g. 20" min="1" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Unit Cost ($) <span style="color:var(--danger);">*</span></label>
            <input type="number" id="restockUnitCost" placeholder="e.g. 12.50" min="0.01" step="0.01" required>
          </div>
          <div class="form-group">
            <label>Restock Date <span style="color:var(--danger);">*</span></label>
            <input type="date" id="restockDate" required>
          </div>
        </div>
        <div class="form-group">
          <label>Notes (Optional)</label>
          <textarea id="restockNotes" placeholder="Any additional notes about this restock..."></textarea>
        </div>
        <div class="btn-group">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Restock</button>
          <button type="button" class="btn btn-outline" id="cancelRestockBtn">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  

  <!-- ALL MODALS (same as before) -->

  <!-- ============================================================ -->
  <!-- SCRIPTS - Load in correct order -->
  <!-- ============================================================ -->

  <!-- 1. API CLIENT -->
  <script src="assets/js/api_client.js"></script>

  <!-- 3. AUTHENTICATION -->
  <script src="assets/js/auth.js"></script>

  <!-- 4. DASHBOARDS -->
  <script src="assets/js/dashboards.js"></script>

  <!-- 5. PROFILE -->
  <script src="assets/js/profile.js"></script>

  <!-- 6. INVENTORY -->
  <script src="assets/js/inventory.js"></script>

  <!-- 7. EMPLOYEES -->
  <script src="assets/js/employees.js"></script>

  <!-- 8. ORDERS -->
  <script src="assets/js/orders.js"></script>

  <!-- 9. CAKES -->
  <script src="assets/js/cakes.js"></script>

  <!-- 10. REPORTS -->
  <script src="assets/js/reports.js"></script>

  <!-- 11. MODALS -->
  <script src="assets/js/modals.js"></script>

  <!-- 12. APP (must load last) -->
  <script src="assets/js/app.js"></script>

</body>
</html>