from src.generic.email import send_email


def handle_contact_post_request(request_form):
    first_name = request_form["first_name"]
    last_name = request_form["last_name"]
    email = request_form["email"]
    phone_number = request_form["phone_number"]
    service_interested = request_form["service_interested"]
    your_message =request_form["your_message"]
    
    subject = "Standard-HC: Recieved Website Contact Message"
    body = f"""\
First Name: {first_name}
Last Name: {last_name}
Email: {email}
Phone Number: {phone_number}
Service Interested: {service_interested}
Your Message: {your_message}
"""
    
    send_email(subject, body)

