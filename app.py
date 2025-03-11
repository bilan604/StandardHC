from flask import Flask, request
from flask import redirect, render_template, url_for

from flask_limiter import Limiter
from flask_limiter.util import get_remote_address

from src.classes.turtle import Turtle

from src.handling.post import handle_contact_post_request


app = Flask(__name__)
limiter = Limiter(get_remote_address, app=app, default_limits=["100 per minute", "1000 per hour"])


#### REFACTOR:

# Tighter limits can be added within function for POST requests, etc
# but it should never exceed these quotas
GLOBAL_SECOND_MAX = "5 per second"
GLOBAL_MINUTE_MAX = "60 per second"

####


@app.route("/contact/", methods=["GET", "POST"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def contact():
    if request.method == "POST":
        handle_contact_post_request(request.form)
        return render_template('contact.html', message="Message has been sent!")    

    return render_template('contact.html', message="Let's Connect")

@app.route("/services/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def services():
    return render_template('services.html')

@app.route("/about/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def about():
    return render_template('about.html')

@app.route("/")
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def home():
    return render_template('index.html')


if __name__ == "__main__":
    app.run(host="http://127.0.0.1:8000")

