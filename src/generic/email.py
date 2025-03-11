import ssl
import smtplib


def send_email(subject, body):
    # Email Configuration

    SMTP_SERVER = "smtp.gmail.com"
    SMTP_PORT = 465  # Use 465 for SSL
    #### #
    EMAIL_SENDER = "bilan604gm@gmail.com"
    EMAIL_PASSWORD = "yevv bolq xkji qyqy"  # Use the generated App Password
    EMAIL_RECEIVER = "bilan604gm@gmail.com"

    message = f"Subject: {subject}\n\n{body}"

    # Send Email
    context = ssl.create_default_context()
    with smtplib.SMTP_SSL(SMTP_SERVER, SMTP_PORT, context=context) as server:
        server.login(EMAIL_SENDER, EMAIL_PASSWORD)
        server.sendmail(EMAIL_SENDER, EMAIL_RECEIVER, message)

    print("Email sent successfully!")