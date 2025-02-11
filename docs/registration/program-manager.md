# Program Manager Registration System

## Program Setup

### Basic Information

-   Title
-   Date Range
    -   From Date
    -   To Date
-   Program Details (textarea)

### Payment Configuration

```json
{
    "price": "decimal",
    "net_amount": "decimal(readonly)",
    "currency": {
        "type": "dropdown",
        "options": ["USD", "CAD"]
    },
    "payment_plan": {
        "enabled": "boolean",
        "installments": [
            {
                "due_date": "date",
                "amount": "decimal"
            }
        ]
    }
}
```

### Discount System

```json
{
    "discount_code": "string",
    "expiration_date": "date(optional)",
    "amount": "decimal",
    "redemption_limit": "integer(optional)",
    "usage_count": "integer"
}
```

## Registration Forms

What Type Of Program Is This? (select)

1. Player Registration
2. Basic Registration

### Player Registration Form

Required fields:

1. Personal Information

    - First Name (text)
    - Last Name (text)
    - Date of Birth (date: MM/DD/YYYY)
    - Gender (select)

2. Address Information

    - Address (text)
    - City (text)
    - State (text)
    - Zip Code (text)

3. Contact Information
    - Contact Name (text)
    - Contact Email (email)
    - Contact Mobile Number (text)

### Basic Registration Form

Required fields:

-   First Name (text)
-   Last Name (text)
-   Mobile Number (text)
-   Email Address (email)

## Custom Questions Builder

Question Types:

-   Short Answer
-   Paragraph
-   Dropdown
-   Checkboxes
-   File Upload
-   Waiver

```json
{
    "question_type": {
        "type": "select",
        "options": [
            "Short Answer",
            "Paragraph",
            "Dropdown",
            "Checkboxes",
            "File Upload",
            "Waiver"
        ]
    }
}
```

### Donations Configuration

```json
{
    "donations_enabled": "boolean",
    "donation_options": {
        "preset_amounts": [0, 25, 50, 75, 100],
        "allow_custom_amount": true,
        "custom_amount": {
            "min": 1,
            "max": 10000
        }
    }
}
```
