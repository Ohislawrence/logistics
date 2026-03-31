# AniqueLogistics Workflow Diagram
**Visual Process Flow Reference**

---

## 📋 COMPLETE ORDER LIFECYCLE

```
┌─────────────────────────────────────────────────────────────┐
│                    ORDER CREATION                            │
│                                                              │
│  Admin logs in → Creates new order                          │
│  • Recipient details                                        │
│  • Pickup address                                           │
│  • Delivery address                                         │
│  • Cost (₦)                                                 │
│                                                              │
│  System generates: TRACKING ID (e.g., ANQ-78432-PHX)       │
│  Status: 🟡 PENDING                                         │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│                 RIDER ASSIGNMENT                             │
│                                                              │
│  Admin assigns order to available rider                     │
│  • Selects rider from dropdown                              │
│  • System sends notification to rider                       │
│                                                              │
│  Status: 🟠 ASSIGNED                                        │
│  Notification: Email + In-app alert to rider               │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│                   PICKUP PHASE                               │
│                                                              │
│  Rider logs in → Views assigned order                       │
│  Rider goes to pickup address                               │
│  Collects package from pharmacy/supplier                    │
│  Rider updates status: "PICKED UP"                          │
│                                                              │
│  Status: 🔵 PICKED UP                                       │
│  Time: Logged automatically                                 │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│                  TRANSIT PHASE                               │
│                                                              │
│  Rider en route to delivery address                         │
│  Uses "Open in Maps" for navigation                         │
│  Rider updates status: "IN TRANSIT"                         │
│                                                              │
│  Status: 🟣 IN TRANSIT                                      │
│  Customer can track on public page                          │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│                  DELIVERY PHASE                              │
│                                                              │
│  Rider arrives at delivery address                          │
│  Hands package to recipient                                 │
│  Rider updates status: "DELIVERED"                          │
│                                                              │
│  Status: 🟢 DELIVERED                                       │
│  Time: Logged automatically                                 │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│                 PAYMENT PHASE                                │
│                                                              │
│  If Cash on Delivery (COD):                                 │
│    • Rider collects cash from recipient                     │
│    • Rider marks order as "PAID"                            │
│    • Amount added to rider's daily earnings                 │
│                                                              │
│  If Pre-paid:                                               │
│    • Admin marks as "PAID" when confirmed                   │
│                                                              │
│  Payment: ✅ PAID                                           │
│  Recorded: Timestamp + User who marked it                   │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔄 ADMIN WORKFLOW MAP

```
                    ┌─────────────────┐
                    │   ADMIN LOGIN   │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │    DASHBOARD    │
                    │                 │
                    │ • Total Orders  │
                    │ • Active Riders │
                    │ • Revenue       │
                    └────────┬────────┘
                             │
         ┌───────────────────┼───────────────────┐
         │                   │                   │
         ▼                   ▼                   ▼
┌────────────────┐  ┌────────────────┐  ┌────────────────┐
│  MANAGE ORDERS │  │  MANAGE RIDERS │  │ VIEW ANALYTICS │
└────────┬───────┘  └────────┬───────┘  └────────────────┘
         │                   │
    ┌────┴────┐         ┌────┴────┐
    │         │         │         │
    ▼         ▼         ▼         ▼
┌────────┐ ┌──────┐ ┌──────┐ ┌──────┐
│ CREATE │ │ EDIT │ │CREATE│ │ EDIT │
│ ORDER  │ │ORDER │ │RIDER │ │RIDER │
└───┬────┘ └──────┘ └──────┘ └──────┘
    │
    ▼
┌────────────────┐
│ ASSIGN TO      │
│ RIDER          │
│                │
│ • Select rider │
│ • Confirm      │
└────────────────┘
```

---

## 🏍️ RIDER WORKFLOW MAP

```
                    ┌─────────────────┐
                    │   RIDER LOGIN   │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │    DASHBOARD    │
                    │                 │
                    │ • Active Orders │
                    │ • Pending       │
                    │ • In Transit    │
                    │ • Earnings      │
                    └────────┬────────┘
                             │
                             ▼
                    ┌────────────────┐
                    │ MY DELIVERIES  │
                    │                │
                    │ View all       │
                    │ assigned orders│
                    └────────┬───────┘
                             │
                             ▼
                    ┌────────────────┐
                    │ SELECT ORDER   │
                    │                │
                    │ View details   │
                    └────────┬───────┘
                             │
         ┌───────────────────┼───────────────────┐
         │                   │                   │
         ▼                   ▼                   ▼
┌────────────────┐  ┌────────────────┐  ┌────────────────┐
│  UPDATE STATUS │  │   VIEW MAPS    │  │  MARK AS PAID  │
│                │  │                │  │                │
│ 1. Picked Up   │  │ Pickup address │  │ Collect cash   │
│ 2. In Transit  │  │ Delivery addr  │  │ Confirm amount │
│ 3. Delivered   │  │                │  │ Mark paid      │
└────────────────┘  └────────────────┘  └────────────────┘
```

---

## 📊 STATUS PROGRESSION CHART

```
START
  │
  │   Admin creates order
  ▼
┌──────────────┐
│   PENDING    │  🟡 Waiting for rider assignment
└──────┬───────┘
       │
       │   Admin assigns rider
       ▼
┌──────────────┐
│   ASSIGNED   │  🟠 Rider notified, ready to pickup
└──────┬───────┘
       │
       │   Rider collects package
       ▼
┌──────────────┐
│  PICKED UP   │  🔵 Package collected, ready for delivery
└──────┬───────┘
       │
       │   Rider starts delivery
       ▼
┌──────────────┐
│  IN TRANSIT  │  🟣 On the way to recipient
└──────┬───────┘
       │
       │   Package handed to recipient
       ▼
┌──────────────┐
│  DELIVERED   │  🟢 Delivery complete!
└──────────────┘
  │
END
```

### Alternative Path:
```
Any Status
     │
     │   Admin cancels order
     ▼
┌──────────────┐
│  CANCELLED   │  🔴 Order cancelled
└──────────────┘
```

---

## 💰 PAYMENT TRACKING FLOW

```
┌─────────────────────────────────────────────────────────┐
│                    PAYMENT TYPES                        │
└─────────────────────────────────────────────────────────┘
                              │
              ┌───────────────┴───────────────┐
              │                               │
              ▼                               ▼
    ┌──────────────────┐           ┌──────────────────┐
    │ CASH ON DELIVERY │           │    PRE-PAID      │
    │      (COD)       │           │                  │
    └─────────┬────────┘           └─────────┬────────┘
              │                               │
              │                               │
    ┌─────────▼─────────┐           ┌─────────▼────────┐
    │ Rider collects    │           │ Admin confirms   │
    │ cash upon         │           │ payment received │
    │ delivery          │           │ (bank transfer,  │
    │                   │           │  mobile money)   │
    └─────────┬─────────┘           └─────────┬────────┘
              │                               │
              │                               │
    ┌─────────▼─────────┐           ┌─────────▼────────┐
    │ Rider marks as    │           │ Admin marks as   │
    │ PAID in app       │           │ PAID in app      │
    └─────────┬─────────┘           └─────────┬────────┘
              │                               │
              └───────────────┬───────────────┘
                              │
                              ▼
                    ┌──────────────────┐
                    │  PAYMENT LOGGED  │
                    │                  │
                    │ • Timestamp      │
                    │ • Paid by (user) │
                    │ • Amount         │
                    └──────────────────┘
                              │
                              ▼
                    ┌──────────────────┐
                    │ ADDED TO REPORTS │
                    │                  │
                    │ • Admin: Revenue │
                    │ • Rider: Earnings│
                    └──────────────────┘
```

---

## 🔔 NOTIFICATION FLOW

```
┌─────────────────────────────────────────────────────────┐
│              TRIGGER EVENTS & NOTIFICATIONS             │
└─────────────────────────────────────────────────────────┘

EVENT: Admin assigns order to rider
  │
  ├─→ Email sent to rider
  │     Subject: "New Delivery Assigned: [Tracking ID]"
  │     Content: Order details + View Order button
  │
  └─→ In-app notification
        Badge appears on dashboard
        Shows in notifications list


EVENT: Order status updated
  │
  └─→ Tracking page updates automatically
        Public customers see real-time status
        No login required


EVENT: Rider marks as paid
  │
  └─→ Admin sees payment update
        Revenue counter updates
        Payment badge changes to green


EVENT: New rider created
  │
  └─→ Welcome email sent to rider
        Login credentials included
        Portal URL provided
```

---

## 🗺️ DATA FLOW DIAGRAM

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│    ADMIN     │         │    SYSTEM    │         │    RIDER     │
└──────┬───────┘         └──────┬───────┘         └──────┬───────┘
       │                        │                        │
       │  Creates order         │                        │
       ├───────────────────────>│                        │
       │                        │                        │
       │  Assigns to rider      │                        │
       ├───────────────────────>│                        │
       │                        │  Notification sent     │
       │                        ├───────────────────────>│
       │                        │                        │
       │                        │  Views order           │
       │                        │<───────────────────────┤
       │                        │                        │
       │                        │  Updates: Picked Up    │
       │                        │<───────────────────────┤
       │                        │                        │
       │                        │  Updates: In Transit   │
       │                        │<───────────────────────┤
       │                        │                        │
       │                        │  Updates: Delivered    │
       │                        │<───────────────────────┤
       │                        │                        │
       │                        │  Marks as Paid         │
       │                        │<───────────────────────┤
       │                        │                        │
       │  Views reports         │                        │
       │<───────────────────────┤                        │
       │                        │                        │


                    ┌──────────────┐
                    │  CUSTOMER    │
                    │  (Public)    │
                    └──────┬───────┘
                           │
                           │  Enters tracking ID
                           │
                           ▼
                    ┌──────────────┐
                    │   TRACKING   │
                    │     PAGE     │
                    │              │
                    │ • Status     │
                    │ • Progress   │
                    │ • Timeline   │
                    └──────────────┘
```

---

## 🎯 ROLE PERMISSIONS TABLE

```
┌─────────────────────────┬──────────┬──────────┬──────────┐
│        ACTION           │  ADMIN   │  RIDER   │ CUSTOMER │
├─────────────────────────┼──────────┼──────────┼──────────┤
│ Create orders           │    ✅    │    ❌    │    ❌    │
│ Edit orders             │    ✅    │    ❌    │    ❌    │
│ Delete orders           │    ✅    │    ❌    │    ❌    │
│ Assign riders           │    ✅    │    ❌    │    ❌    │
│ View all orders         │    ✅    │    ❌    │    ❌    │
│ View assigned orders    │    ✅    │    ✅    │    ❌    │
│ Update order status     │    ✅    │    ✅    │    ❌    │
│ Mark as paid            │    ✅    │    ✅    │    ❌    │
│ Create riders           │    ✅    │    ❌    │    ❌    │
│ Edit riders             │    ✅    │    ❌    │    ❌    │
│ Track order (public)    │    ✅    │    ✅    │    ✅    │
│ View dashboard stats    │    ✅    │    ✅    │    ❌    │
│ View revenue            │    ✅    │    ❌    │    ❌    │
│ View personal earnings  │    ❌    │    ✅    │    ❌    │
└─────────────────────────┴──────────┴──────────┴──────────┘
```

---

## 📈 EXAMPLE TIMELINE

```
DAY IN THE LIFE OF AN ORDER:

08:30 AM  │  Admin creates order #ANQ-78432-PHX
          │  Recipient: John Doe
          │  Pickup: Central Pharmacy
          │  Delivery: 123 Main St, Lagos
          │  Cost: ₦2,500
          │  Status: 🟡 PENDING
          │
08:35 AM  │  Admin assigns to Rider "Chidi"
          │  Status: 🟠 ASSIGNED
          │  📧 Email sent to Chidi
          │
09:15 AM  │  Chidi views order on phone
          │  Leaves for Central Pharmacy
          │
09:45 AM  │  Chidi arrives at pharmacy
          │  Collects package (insulin medication)
          │  Updates status: 🔵 PICKED UP
          │
10:00 AM  │  Chidi on motorcycle to delivery
          │  Uses Maps for navigation
          │  Updates status: 🟣 IN TRANSIT
          │
10:45 AM  │  Chidi arrives at 123 Main St
          │  Hands package to John Doe
          │  Collects ₦2,500 cash
          │  Updates status: 🟢 DELIVERED
          │
10:47 AM  │  Chidi marks order as PAID
          │  ₦2,500 added to daily earnings
          │
          │  ✅ Order complete!
          │  Total time: 2 hours 17 minutes
```

---

## 🔍 QUICK REFERENCE ICONS

```
Status Icons:
🟡 Pending       - Just created, no rider
🟠 Assigned      - Rider assigned, awaiting pickup
🔵 Picked Up     - Package collected
🟣 In Transit    - Delivery in progress
🟢 Delivered     - Complete!
🔴 Cancelled     - Order cancelled

Action Icons:
✏️  Edit         - Modify order/rider details
👁️  View         - See full details
🗑️  Delete       - Remove order/rider
🔔 Notify        - Send alert
💰 Pay          - Mark as paid
📧 Email        - Send notification
📍 Map          - Open in maps
📞 Call         - Contact recipient
```

---

**Last Updated:** March 31, 2026  
**Version:** 1.0  
**System:** AniqueLogistics Drug Delivery Platform

For detailed step-by-step instructions, see:
- **ADMIN_RIDER_USER_GUIDE.md** (Full documentation)
- **QUICK_START_GUIDE.md** (Quick reference)
