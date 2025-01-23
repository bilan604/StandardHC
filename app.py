from flask import Flask
from flask import redirect, render_template, url_for

app = Flask(__name__)

@app.route("/")
def home():
    print("home route reached.")
    return render_template('index.html')

if __name__ == "__main__":
    app.run(host="http://127.0.0.1:8000")
