from flask import Flask, request, session
from flask import redirect, render_template, url_for

from flask_limiter import Limiter
from flask_limiter.util import get_remote_address

from flask import make_response, redirect

from src.classes.turtle import Turtle

from src.handling.post import handle_contact_post_request


app = Flask(__name__)
limiter = Limiter(get_remote_address, app=app, default_limits=["100 per minute", "1000 per hour"])

# Tighter limits can be added within function for POST requests, etc
# but it should never exceed these quotas
GLOBAL_SECOND_MAX = "5 per second"
GLOBAL_MINUTE_MAX = "60 per second"

# Routes:
#/
#/about
#/about_history
#/about_advantage
#/about_cultural_vision
#/service
#/service_function_specific
#/service_caiwuguanlizixun
#/service_directors
#/process
#/process_development
#/process_operating_guidelines
#/cases
#/contact

@app.route('/set_language/<lang_code>')
def set_language(lang_code):
    if lang_code not in ['en', 'zh']:
        lang_code = 'zh'  # fallback
    
    resp = make_response(redirect(request.referrer or url_for('/')))
    resp.set_cookie('language', lang_code, max_age=60*60*24*365)  # 1 year
    return resp

#/
@app.route("/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def home():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/index.html')
    return render_template('index.html')

#/about
@app.route("/about/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def about():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/about.html')
    return render_template('about.html')

#/about_history
@app.route("/about_history/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def about_history():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/about_history.html')
    return render_template('about_history.html')

#/about_advantage
@app.route("/about_advantage/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def about_advantage():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/about_advantage.html')
    return render_template('about_advantage.html')

#/about_cultural_vision
@app.route("/about_cultural_vision/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def about_cultural_vision():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/about_cultural_vision.html')
    return render_template('about_cultural_vision.html')

#/service
@app.route("/service/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def service():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/service.html')
    return render_template('service.html')

#/service_function_specific
@app.route("/service_function_specific/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def service_function_specific():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/service_function_specific.html')
    return render_template('service_function_specific.html')

#/service_caiwuguanlizixun
@app.route("/service_caiwuguanlizixun/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def service_caiwuguanlizixun():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/service_caiwuguanlizixun.html')
    return render_template('service_caiwuguanlizixun.html')

#/service_directors
@app.route("/service_directors/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def service_directors():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/service_directors.html')
    return render_template('service_directors.html')

#/process
@app.route("/process/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def process():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/process.html')
    return render_template('process.html')

#/process_development
@app.route("/process_development/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def process_development():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/process_development.html')
    return render_template('process_development.html')

#/process_operating_guidelines
@app.route("/process_operating_guidelines/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def process_operating_guidelines():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/process_operating_guidelines.html')
    return render_template('process_operating_guidelines.html')

#/cases
@app.route("/cases/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def cases():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/cases.html')
    return render_template('cases.html')

#/contact
@app.route("/contact/", methods=["GET"])
@limiter.limit(GLOBAL_SECOND_MAX)
@limiter.limit(GLOBAL_MINUTE_MAX)
def contact():
    lang = request.cookies.get('language', 'zh')
    if lang == 'en':
        return render_template('english/contact.html')
    return render_template('contact.html')

# TODO: "/": "/"
# ?


if __name__ == "__main__":
    
    app.run(host="http://127.0.0.1:8000")
    # suggested: 'change to app.run(host="127.0.0.1", port=8000) to avoid a ValueError on app startup',
    # but no errors observed using app.run(host="http://127.0.0.1:8000")
