from flask import Flask, request
from flask import redirect, render_template, url_for


app = Flask(__name__)


@app.route("/contact/", methods=["GET", "POST"])
def contact():
    if request.method == "POST":

        def handle_contact_post_request(request_form):
            first_name = request_form["first_name"]
            last_name = request_form["last_name"]
            email = request_form["email"]
            phone_number = request_form["phone_number"]
            service_interested = request_form["service_interested"]
            your_message =request_form["your_message"]
            print(f"MESSAGE INFO:\n{first_name}\n{last_name}\n{email}\n{phone_number}\n{service_interested}\n{your_message}")

        handle_contact_post_request(request.form)
        return render_template('contact.html', message="Message has been sent!")    

    print("contact route reached.")
    return render_template('contact.html', message="Let's Connect")

@app.route("/services/", methods=["GET"])
def services():
    print("services route reached.")
    return render_template('services.html')

@app.route("/about/", methods=["GET"])
def about():
    print("about route reached.")
    return render_template('about.html')

@app.route("/")
def home():
    print("home route reached.")
    return render_template('index.html')


if __name__ == "__main__":
    app.run(host="http://127.0.0.1:8000")

