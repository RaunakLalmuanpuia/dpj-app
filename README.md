
Flow: Auth First, Then Payment
1. User selects a plan
2. Google OAuth authentication
    - User signs in with Gmail
    - Request Google Drive permissions
    - Verify it's a Gmail account
    - Save user to System
3. Redirect to payment page (with plan pre-selected)
4. Payment processing
5. Create Google Drive folder & add sheets
6. Send confirmation email
7. Redirect to dashboard/success page
