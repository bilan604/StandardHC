import ssl
import smtplib

import os
from dotenv import load_dotenv
load_dotenv()


def send_email(subject, body):
    # Email Configuration
    SMTP_SERVER = "smtp.gmail.com"
    SMTP_PORT = 465  # Use 465 for SSL
    
    EMAIL_SENDER = os.getenv("CONTACT_EMAIL_SENDER")
    EMAIL_RECEIVER = os.getenv("CONTACT_EMAIL_RECEIVER")
    EMAIL_PASSWORD = os.getenv("CONTACT_EMAIL_PASSWORD")

    message = f"Subject: {subject}\n\n{body}"
    
    #### Create an SSL context that does NOT verify certificates (INSECURE)
    context = ssl._create_unverified_context()

    with smtplib.SMTP_SSL(SMTP_SERVER, SMTP_PORT, context=context) as server:
        server.login(EMAIL_SENDER, EMAIL_PASSWORD)
        server.sendmail(EMAIL_SENDER, EMAIL_RECEIVER, message)

