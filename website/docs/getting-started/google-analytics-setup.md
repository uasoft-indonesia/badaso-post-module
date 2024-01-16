---
sidebar_position: 2
---

# Google Analytics Setup 

## Getting credentials JSON
1. Head over to  [Google API’s site](https://console.cloud.google.com/) using your google account and select or create a project.
 ![Imgur](https://i.imgur.com/PuMoMVM.png)
1. Set API's the project. Go to the API Library and search for "Google Analytics Data API".
 ![Imgur](https://i.imgur.com/5hCgMnF.png)
 ![Imgur](https://imgur.com/PEtz6sk.png)
1. Choose enable to enable the API.
 ![Imgur](https://imgur.com/JshNpEh.png)
1. If you dont have an Analytics account before, fill in the form like image below.

    - Go to [Analytics site](https://analytics.google.com/analytics/web). Fill account name
    ![Imgur](https://imgur.com/yS7HV3P.png)
    - Fill in property name, reporting time zone and currency.
    ![Imgur](https://imgur.com/UEIJOK3.png)
    - Check anything that your business is about.
    ![Imgur](https://imgur.com/6Rd3FIe.png)
    - Check anything that your business objective.
    ![Imgur](https://imgur.com/jStlyFx.png)
    - Choose data collection to get Analytics Tracking ID
    ![Imgur](https://imgur.com/bCG7FTx.png)

1. Go to [Google API](https://console.cloud.google.com/apis/dashboard) and select a project that you want from the header.
1. Go to [Credential](https://console.cloud.google.com/apis/credentials) and create a new credential. Click **Create Credentials** and select **Service account**.

![Imgur](https://i.imgur.com/nS7m6rZ.png)

1. Fill in the form with service account name and account ID that you like. After that, click **Create** button and click **Done**.

![Imgur](https://i.imgur.com/PhCaP9Z.png)

1. To obtain service account credential JSON, press edit on the new created service account.
![Imgur](https://i.imgur.com/pXbDdHy.png)

1. Select **KEYS** menu from the tab. Click Add Key and select **Create new key**. After that, select JSON and click **Create** button.
![Imgur](https://i.imgur.com/oexLid9.png)

1. After you create the key, it'll automatically download the key.
1. Place your .json key to storage directory like below.

```php
📦 Your Project
 ┣ 📂 storage
 ┃ ┣ 📂 app
 ┃ ┃ ┣ 📂 analytics // If the directory doesn't exists, just create it
 ┃ ┃ ┃ ┗ 📜 service-account-credentials.json // Filename must be the same
```

## Granting permissions to your Analytics property

1. Go to [Google Analytics](http://analytics.google.com/) page.
1. Select **Admin** menu from sidebar. Select Property access management
![Imgur](https://imgur.com/chIY1ov.png)
![Imgur](https://imgur.com/HlnzQmw.png)
1. New window will appear, after that click **Add users**.
![Imgur](https://i.imgur.com/BCVGUH4.png)
1. Open the credential that we get before, search for `client_email`. Copy the email.
![Imgur](https://i.imgur.com/A7CPWQB.png)
1. Paste it in the **Email addresses** field and select permission that you want. **You must check Viewer permissions**. After that, press **Done** button.
![Imgur](https://imgur.com/ms314Ek.png)

## Getting the ID that you need.

### Account ID

1. Select Admin menu from sidebar and select Account Details.
![Imgur](https://imgur.com/FXzIwrL.png)

1. There you have it. 
![Imgur](https://imgur.com/g0cv2if.png)

### Property ID / View ID
1. Select Admin menu from sidebar and select Property Details. There you have it
![Imgur](https://imgur.com/eELpvws.png)

## Tracking ID
1. Go to Analytics Home menu. There you have it
![Imgur](https://imgur.com/LByg6fc.png)

### Web Property ID

1. Open [Google Analytics](http://analytics.google.com/) page.
2. Look at the page URL. The web property ID start with **p**. Usually it has 9 character. For example: 
https://analytics.google.com/analytics/web/#/p299999997/reports/intelligenthome

   The web property ID for that account is 299999997.

![Imgur](https://imgur.com/sW8ZBda.png)
