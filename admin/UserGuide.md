# Teriyaki Tradesmen - Administration User Guide

This guide provides instructions on how to use the administration features of the Teriyaki Tradesmen website.

## Table of Contents

1.  [Accessing the Admin Panel](#accessing-the-admin-panel)
2.  [Managing Events](#managing-events)
3.  [Sending Emails](#sending-emails)
4.  [Viewing the Email Log](#viewing-the-email-log)
5.  [Uploading and Sending HTML Emails](#uploading-and-sending-html-emails)
6.  [Editing and Sending HTML Emails](#editing-and-sending-html-emails)
7.  [Best Practices](#best-practices)
8.  [Troubleshooting](#troubleshooting)

## 1. Accessing the Admin Panel

1.  **Open Your Web Browser:** Launch your preferred web browser.
2.  **Navigate to the Admin Page:** Enter the URL for the admin panel: `your-website.com/admin/schedule.php`
3.  **Login:**
    *   Enter your administrator password in the provided field.
    *   Click the "Login" button.

    **Note:** If you have entered the wrong password too many times, you will be locked out for a short period.

## 2. Managing Events

The event management section allows you to add, cancel, and clean up events.

1.  **Access the Schedule Admin Page:** After logging in, you will be on the Schedule Administration page.
2.  **Adding a New Event:**
    *   Locate the "Add New Event" section on the left side.
    *   Fill in the event details:
        *   **Date:** Select the event date from the calendar.
        *   **Time:** Enter the time range (e.g., "11:00 AM - 3:00 PM").
        *   **Location:** Enter the venue name or description.
        *   **Address:** Enter the complete street address.
    *   Click the "Add Event" button.
3.  **Managing Existing Events:**
    *   Events are displayed on the right side of the page.
    *   **To Cancel an Event:**
        *   Find the event in the list.
        *   Click the "Cancel" button next to it.
        *   The event will be marked as cancelled but remain visible.
    *   **To Clean Up Expired Events:**
        *   Scroll to the bottom of the events list.
        *   Click the "Clean up expired events" button.
        *   This removes cancelled events that are in the past. Active future events are not affected.

## 3. Sending Emails

The "Send Email" page allows you to send emails to your subscribers.

1.  **Access the Admin Links Page:** After logging in, click on the "Admin Links" link.
2.  **Navigate to the Send Email Page:** Click on the "Send Email" link.
3.  **Compose Your Email:**
    *   Enter the subject of your email in the "Subject" field.
    *   Enter the body of your email in the "Body" field.
    *   Click the "Send Email" button.

## 4. Viewing the Email Log

The "Email Log" page allows you to view a list of all sent emails.

1.  **Access the Admin Links Page:** After logging in, click on the "Admin Links" link.
2.  **Navigate to the Email Log Page:** Click on the "Email Log" link.
3.  **View Sent Emails:**
    *   The page will display a list of all sent emails, sorted by date and time.
    *   Click on the subject of an email to view its details.

## 5. Uploading and Sending HTML Emails

The "Upload & Send HTML Email" page allows you to upload an HTML file and send it as an email.

1.  **Access the Admin Links Page:** After logging in, click on the "Admin Links" link.
2.  **Navigate to the Upload & Send HTML Email Page:** Click on the "Upload & Send HTML Email" link.
3.  **Upload and Send:**
    *   Enter the subject of your email in the "Subject" field.
    *   Click the "Choose File" button to select an HTML file from your computer.
    *   Click the "Send Email" button.

## 6. Editing and Sending HTML Emails

The "Edit & Send HTML Email" page allows you to edit HTML content using TinyMCE and send it as an email.

1.  **Access the Admin Links Page:** After logging in, click on the "Admin Links" link.
2.  **Navigate to the Edit & Send HTML Email Page:** Click on the "Edit & Send HTML Email" link.
3.  **Edit and Send:**
    *   Enter the subject of your email in the "Subject" field.
    *   Use the TinyMCE editor to create or modify your HTML content.
    *   Click the "Send Email" button.

## 7. Best Practices

1.  **Regular Maintenance:**
    *   Clean up expired events weekly.
    *   Review upcoming events for accuracy.
    *   Keep the schedule up-to-date.
2.  **Event Details:**
    *   Use consistent time formats (e.g., "11:00 AM - 3:00 PM").
    *   Include complete addresses.
    *   Double-check all information before adding.
3.  **Schedule Management:**
    *   Add new events as soon as they're confirmed.
    *   Cancel events promptly if needed.
    *   Maintain at least 2 weeks of upcoming events.
4.  **Email Content:**
    *   Use clear and concise language.
    *   Avoid using excessive images or large attachments.
    *   Test your emails before sending them to your entire list.
5.  **Security:**
    *   Keep your admin password secure.
    *   Do not share your login credentials with unauthorized users.

## 8. Troubleshooting

Common issues and solutions:

1.  **Can't Log In:**
    *   Check if Caps Lock is on.
    *   Ensure you're using the correct password.
    *   Clear browser cache and try again.
    *   If you have entered the wrong password too many times, you will be locked out for a short period.
2.  **Event Not Showing Up:**
    *   Verify the date is correct.
    *   Check if the event was accidentally cancelled.
    *   Ensure all required fields were filled out.
3.  **Email Not Sending:**
    *   Double-check your SMTP settings in the `.env` file.
    *   Verify that your SMTP server is working correctly.
    *   Check your spam folder.
    *   Check your server's error logs for any PHPMailer errors.
4.  **Email Not Recorded:**
    *   Check your server's error logs for any database errors.
    *   Verify that the `sent_emails` table exists in your `schedule.db` file.
5.  **Need Help?**
    *   Contact technical support:
        *   Email: \[your-support-email]
        *   Phone: \[your-support-phone]

---

**Remember**: Keep this manual and your admin password secure. Never share your login credentials with unauthorized users.
