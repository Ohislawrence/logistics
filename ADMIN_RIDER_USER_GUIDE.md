# AniqueLogistics User Guide
**Drug Delivery Management System**

---

## Table of Contents
1. [Admin Flow](#admin-flow)
2. [Rider Flow](#rider-flow)
3. [Order Status Workflow](#order-status-workflow)
4. [Payment Management](#payment-management)
5. [Quick Reference](#quick-reference)

---

## Admin Flow

### 1. Dashboard Overview
After logging in, admins land on the dashboard with key metrics:
- **Total Orders**: All orders in the system
- **Active Riders**: Number of registered delivery riders
- **Total Revenue**: Sum of all paid orders
- **Recent Orders**: Latest 5 orders created

**Quick Actions:**
- View orders by status (pending, in transit, delivered, etc.)
- Access rider management
- Monitor system-wide performance

---

### 2. Order Management

#### A. Creating a New Order
**Path:** Dashboard → Manage Orders → Create Order

**Steps:**
1. **Recipient Information**
   - Enter recipient's full name (required)
   - Add phone number (optional but recommended)

2. **Delivery Details**
   - **Pickup Address**: Where to collect the medication/package
   - **Delivery Address**: Final destination for delivery
   - **Cost**: Delivery fee in Naira (₦)

3. **Additional Information**
   - Add special notes or instructions
   - Set any temperature requirements

4. **Save Order**
   - System automatically generates a unique **Tracking ID** (e.g., ANQ-78432-PHX)
   - Order status starts as **"Pending"**

#### B. Viewing All Orders
**Path:** Dashboard → Orders Management

**Features:**
- **Summary Cards**: View counts for Pending, In Transit, and Delivered orders
- **Search & Filter**:
  - Search by tracking ID or recipient name
  - Filter by status (Pending, Assigned, Picked Up, In Transit, Delivered, Cancelled)
  - Filter by payment status (Paid/Unpaid)
- **Bulk Actions**: Export data, filter by date range

**Order Table Columns:**
- Tracking ID
- Recipient Name
- Assigned Rider
- Cost (₦)
- Status Badge
- Payment Status
- Actions (Edit, Assign, Mark Paid, Delete)

#### C. Assigning Orders to Riders
**Steps:**
1. Locate the order in the Orders list
2. Click **"Assign Rider"** button
3. Select an available rider from dropdown
4. Confirm assignment

**What Happens:**
- Order status changes from "Pending" to **"Assigned"**
- Rider receives email and in-app notification
- Order appears in rider's dashboard
- Tracking page shows "Assigned to Rider"

#### D. Editing Orders
**Path:** Orders → Edit (pencil icon)

**Editable Fields:**
- Recipient details
- Pickup and delivery addresses
- Cost
- Notes
- Status (if needed for corrections)

**Note:** Cannot edit orders that are already delivered or cancelled.

---

### 3. Rider Management

#### A. Creating a New Rider Account
**Path:** Dashboard → Riders → Create Rider

**Steps:**
1. Enter rider's full name
2. Provide email address (used for login)
3. Set initial password
4. Add phone number
5. Assign "Rider" role (automatic)

**What Happens:**
- Rider account created with login credentials
- Rider receives welcome email with login details
- Account appears in Riders list

#### B. Viewing All Riders
**Path:** Dashboard → Riders Management

**Features:**
- **Summary Cards**: Total Riders, Active Riders, Total Deliveries, Average Rating
- **Search & Filter**: Search by name or email
- **Rider Table Shows**:
  - Rider name
  - Contact info (email, phone)
  - Status (Active/Inactive/On Delivery)
  - Number of deliveries completed
  - Actions (View, Edit, Delete)

#### C. Monitoring Rider Performance
**Path:** Riders → View (eye icon)

**Rider Detail Page Shows:**
- Personal information
- Total deliveries completed
- Current assigned orders
- Completed orders
- Payment history
- Performance metrics

---

### 4. Payment Management (Admin)

#### Marking Orders as Paid
**Steps:**
1. Go to Orders list
2. Find the unpaid order
3. Click **"Mark as Paid"** button
4. Confirm payment receipt

**What Happens:**
- Payment badge changes from "Unpaid" to "Paid"
- Payment timestamp recorded
- Admin's name recorded as "Paid By"
- Amount added to revenue total

---

## Rider Flow

### 1. Rider Dashboard Overview
After login, riders see:
- **Active Orders**: Total orders currently assigned
- **Pending Pickup**: Orders not yet collected
- **In Transit**: Orders currently being delivered
- **Today's Earnings**: Total from paid orders completed today

**Quick Stats:**
- Today's progress bar (completed vs remaining)
- Recent assigned orders (latest 5)

---

### 2. Managing Deliveries

#### A. Viewing Assigned Orders
**Path:** Dashboard → My Deliveries

**Features:**
- **Summary Cards**: Total, Pending Pickup, In Transit, Completed Today
- **Search**: Search by tracking ID or recipient name
- **Filter by Status**: Assigned, Picked Up, In Transit, Delivered

**Order List Shows:**
- Tracking ID
- Recipient name
- Delivery cost
- Current status
- Payment status
- View Details button

#### B. Order Detail Page
**Path:** My Deliveries → View Order

**Information Displayed:**
- **Status Banner**: Current order status with color-coded badge
- **Payment Status**: Paid/Unpaid indicator
- **Recipient Details**: Name and phone (with clickable call link)
- **Delivery Cost**: Amount to collect (₦)
- **Pickup Address**: With "Open in Maps" button
- **Delivery Address**: With "Open in Maps" button
- **Special Notes**: Any instructions from admin

---

### 3. Updating Order Status (Rider Workflow)

#### Status Update Steps:

**1. When Order is Assigned:**
- Rider logs in and sees order in "Assigned" status
- Reviews order details and addresses

**2. Going to Pick Up:**
- Rider updates status to **"Picked Up"**
- Indicates they've collected the package from pharmacy/pickup location

**3. During Delivery:**
- Rider updates status to **"In Transit"**
- Indicates they're on the way to delivery address

**4. Upon Delivery:**
- Rider updates status to **"Delivered"**
- Indicates successful delivery to recipient

**How to Update Status:**
1. Open the order detail page
2. Scroll to "Update Status" section
3. Select new status from dropdown:
   - Assigned → Picked Up
   - Picked Up → In Transit
   - In Transit → Delivered
4. Add optional notes about the delivery
5. Click **"Update Status"** button

**What Happens:**
- Status updates immediately
- Tracking page updates for public visibility
- Progress logged with timestamp
- Admin can see status change in real-time

---

### 4. Payment Collection (Rider)

#### Marking Payment as Received
**When:** Upon delivery, if payment is Cash on Delivery (COD)

**Steps:**
1. On order detail page, verify amount: ₦X.XX
2. Collect cash from recipient
3. Click **"Mark as Paid"** button
4. Confirm payment received

**What Happens:**
- Payment status changes to "Paid"
- Timestamp and rider's name recorded
- Amount added to "Today's Earnings"
- Admin sees payment received notification

**Important:**
- Only mark as paid when you physically receive the money
- Double-check the amount shown
- Cash must be remitted to admin according to company policy

---

## Order Status Workflow

### Complete Status Flow:
```
1. PENDING
   ↓ (Admin assigns to rider)
2. ASSIGNED
   ↓ (Rider collects package)
3. PICKED_UP
   ↓ (Rider en route to delivery)
4. IN_TRANSIT
   ↓ (Package delivered to recipient)
5. DELIVERED ✓
```

### Alternative Statuses:
- **CANCELLED**: Order cancelled by admin (can happen at any stage before delivery)

### Status Descriptions:
| Status | Description | Who Can Update |
|--------|-------------|----------------|
| **Pending** | Order created, awaiting rider assignment | Admin only |
| **Assigned** | Rider assigned, ready for pickup | Admin |
| **Picked Up** | Package collected from pickup location | Rider only |
| **In Transit** | En route to delivery address | Rider only |
| **Delivered** | Successfully delivered to recipient | Rider only |
| **Cancelled** | Order cancelled | Admin only |

---

## Payment Management

### Payment Status Types:
1. **Unpaid** (Yellow badge): Payment not yet received
2. **Paid** (Green badge): Payment confirmed

### Who Can Mark as Paid:
- **Admin**: Can mark any order as paid
- **Rider**: Can mark their assigned orders as paid

### Payment Fields Tracked:
- `paid`: Boolean (true/false)
- `paid_at`: Timestamp when marked paid
- `paid_by`: User ID of admin or rider who marked it

### Payment Reports:
- **Admin**: Views total revenue on dashboard
- **Rider**: Views today's earnings on dashboard

---

## Quick Reference

### Key Features Summary:

#### Admin Can:
✅ Create new orders  
✅ Edit order details  
✅ Assign orders to riders  
✅ Mark orders as paid  
✅ Create/manage rider accounts  
✅ View all orders and riders  
✅ Monitor revenue and performance  
✅ Cancel orders  

#### Riders Can:
✅ View assigned orders  
✅ Update order status (Picked Up → In Transit → Delivered)  
✅ Mark orders as paid (when receiving cash)  
✅ View delivery addresses in maps  
✅ Call recipients directly from app  
✅ View today's earnings  
✅ Track personal delivery performance  

### Navigation Shortcuts:

**Admin:**
- Dashboard: Main overview with stats
- Orders: `/admin/orders`
- Create Order: `/admin/orders/create`
- Riders: `/admin/riders`

**Rider:**
- Dashboard: Main overview with stats
- My Deliveries: `/rider/orders`
- View Order: Click on any order from list

---

## Public Order Tracking

### Customer Tracking Features:
**URL:** `yoursite.com/track-order`

Customers can:
- Enter tracking ID (e.g., ANQ-78432-PHX)
- View real-time order status
- See delivery progress with timeline
- View recipient details and addresses
- Check payment status

**Status Indicators:**
- Color-coded badges for each stage
- Progress bar showing delivery journey
- Timestamp for each status update
- Live temperature monitoring (if applicable)

---

## Contact & Support

For technical issues or questions:
- WhatsApp floating button on homepage
- Email support (check app settings)
- Admin dashboard support link

---

## Important Notes

### Best Practices:

**For Admins:**
1. Always verify rider availability before assignment
2. Double-check addresses to avoid delivery errors
3. Set realistic costs based on distance
4. Assign orders promptly to ensure timely delivery
5. Monitor unpaid orders regularly

**For Riders:**
1. Update status in real-time as you progress
2. Contact recipient if address is unclear
3. Mark payments immediately upon cash collection
4. Use map integration for accurate navigation
5. Add notes for any delivery issues

### Security:
- All users have secure passwords
- Only assigned riders can update their orders
- Payment tracking for accountability
- Audit trail on all status changes

---

## Troubleshooting

### Common Issues:

**Order not appearing for rider?**
- Ensure admin assigned it properly
- Refresh the page or log out and back in
- Check notifications for assignment alert

**Cannot update order status?**
- Ensure you're the assigned rider
- Check that order isn't already delivered/cancelled
- Verify internet connection

**Payment not reflecting?**
- Confirm "Mark as Paid" button was clicked
- Check if page refreshed after marking
- Contact admin if issue persists

---

**Last Updated:** March 31, 2026  
**Version:** 1.0  
**System:** AniqueLogistics Drug Delivery Platform
