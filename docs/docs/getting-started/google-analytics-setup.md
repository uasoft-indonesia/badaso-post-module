---
sidebar_position: 2
---

# Google Analytics Setup
## Getting credentials JSON

1. Go to [Google Analytics](http://analytics.google.com/) page.
2. Login using Google Account.
3. If you dont have an Analytics account before, fill in the form like image below. 

    - Fill in account name. On **Account Data Sharing Settings**, check options that you want.
    ![Imgur](https://i.imgur.com/f6grepG.png)
    - Fill in poperty name, reporting time zone and currency.
    ![Imgur](https://i.imgur.com/tqjv2JS.png)
    - Click **Show advanced options**.
    - Fill in website URL with your site URL. Don't forget to check **Create a Universal Analytics property only**.
    ![Imgur](https://i.imgur.com/sBBNTQh.png)
    - Check anything that your business is about.
    ![Imgur](https://i.imgur.com/nEDZcGA.png)
    - After that, click the **Create** button and modal will appear then press **I Accept** button.

4. Go to [Google API](https://console.cloud.google.com/apis/dashboard) and select a project that you want from the header.
5. Go to [Credential](https://console.cloud.google.com/apis/credentials) and create a new credential. Click **Create Credentials** and select **Service account**.

![Imgur](https://i.imgur.com/nS7m6rZ.png)

6. Fill in the form with service account name and account ID that you like. After that, click **Create** button and click **Done**.

![Imgur](https://i.imgur.com/PhCaP9Z.png)

7. To obtain service account credential JSON, press edit on the new created service account.
![Imgur](https://i.imgur.com/pXbDdHy.png)

8. Select **KEYS** menu from the tab. Click Add Key and select **Create new key**. After that, select JSON and click **Create** button.
![Imgur](https://i.imgur.com/oexLid9.png)

9. After you create the key, it'll automatically download the key.
10. Place your .json key to storage directory like below.

```php
📦 Your Project
 ┣ 📂 storage
 ┃ ┣ 📂 app
 ┃ ┃ ┣ 📂 analytics // If the directory doesn't exists, just create it
 ┃ ┃ ┃ ┗ 📜 service-account-credentials.json // Filename must be the same
```

## Granting permissions to your Analytics property

1. Go to [Google Analytics](http://analytics.google.com/) page.
2. Select **Admin** menu from sidebar. Select **View User Management**.
![Imgur](https://i.imgur.com/PeKLoZ3.png)
3. New window will appear, after that click **Add users**.
![Imgur](https://i.imgur.com/BCVGUH4.png)
4. Open the credential that we get before, search for `client_email`. Copy the email.
![Imgur](https://i.imgur.com/A7CPWQB.png)
5. Paste it in the **Email addresses** field and select permission that you want. **You must check the Read & Analyze permissions**. After that, press **Done** button.
![Imgur](https://i.imgur.com/gzDv7sb.png)

## Getting the ID that you need.

### View ID

1. Select Admin menu from sidebar and select View Settings.
![Imgur](https://i.imgur.com/07rzLN4.png)

2. There you have it. 
![Imgur](https://i.imgur.com/hsLpo0A.png)

### Property ID / Tracking ID

1. Select Admin menu from sidebar and there you have it.
![Imgur](https://i.imgur.com/LdY7YVz.png)

### Account ID

1. Select Admin menu from sidebar and select Account Settings.
![Imgur](https://i.imgur.com/G34Uwxs.png)

2. There you have it. 
![Imgur](https://i.imgur.com/dCvEycA.png)

### Web Property ID

1. Open [Google Analytics](http://analytics.google.com/) page.
2. Look at the page URL. The web property ID start with **w**. Usually it has 9 character. For example: 
https://analytics.google.com/analytics/web/?authuser=1#/report-home/a000000000w299999997p000000000

   The web property ID for that account is 299999997.

![Imgur](https://i.imgur.com/XWimJm5.png)