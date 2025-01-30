from flask import Flask, request, jsonify
import requests

app = Flask(__name__)

# WhatsApp API credentials
WHATSAPP_API_URL = "https://graph.facebook.com/v17.0/me/messages"
ACCESS_TOKEN = "EAANn64yDGEkBO2xfYM9l4UrfxsVpYqXQdZCgtoaWvdCblF9DFXmWXCYmcfpylfjr1TFhaCiTQIqmGiNWfxh8lPD2R8bwP5EgQ8046hwZBvC3qC3C4nlKvKmFlGWZBZAaQ4IugcmRIQbCLpgjZCwX6ZCEdDQZC2LWH6JI0Hn1zn1p2nd0BEEIzZA4cGXImHNxtzRhsZATszd9TJ71ziriT2xn31yMINqh3"  # Weka token uliyopata kwenye Meta for Developers
PHONE_NUMBER_ID = "YOUR_PHONE_NUMBER_ID"  # Weka ID ya nambari yako ya WhatsApp

# Laravel API URL
LARAVEL_API_URL = "http://your-laravel-app.com/api"  # Badilisha kwa URL ya Laravel project yako

@app.route('/webhook', methods=['POST'])
def webhook():
    data = request.json
    message = data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body']
    sender = data['entry'][0]['changes'][0]['value']['messages'][0]['from']

    if "matokeo" in message.lower():
        response = get_student_marks(sender)
    elif "malipo" in message.lower():
        response = get_student_payments(sender)
    else:
        response = "Samahani, sijaelewa ombi lako. Tafadhali jaribu tena."

    send_whatsapp_message(sender, response)
    return jsonify({"status": "success"})

def get_student_marks(student_number):
    response = requests.get(f"{LARAVEL_API_URL}/marks/Class_A/{student_number}")
    if response.status_code == 200:
        data = response.json()
        marks_summary = "Matokeo ya mwanako:\n"
        marks_summary += f"- Sayansi: {data['subject_1']}\n"
        marks_summary += f"- Hisabati: {data['subject_2']}\n"
        marks_summary += f"- English: {data['subject_3']}\n"
        marks_summary += f"- Jumla ya alama: {data['total_marks']}\n"
        marks_summary += f"- Wastani: {data['average_marks']}\n"
        marks_summary += f"- Nafasi: {data['position']}\n"
        return marks_summary
    else:
        return "Samahani, matokeo hayawezi kupatikana kwa sasa."

def get_student_payments(student_number):
    response = requests.get(f"{LARAVEL_API_URL}/payments/Class_A/{student_number}")
    if response.status_code == 200:
        data = response.json()
        payments_summary = "Malipo ya mwanako:\n"
        for payment in data:
            payments_summary += f"- {payment['payment_type']}: {payment['amount']}\n"
        return payments_summary
    else:
        return "Samahani, taarifa za malipo haziwezi kupatikana kwa sasa."

def send_whatsapp_message(to, message):
    headers = {
        "Authorization": f"Bearer {ACCESS_TOKEN}",
        "Content-Type": "application/json"
    }
    payload = {
        "messaging_product": "whatsapp",
        "to": to,
        "text": {"body": message}
    }
    response = requests.post(WHATSAPP_API_URL, headers=headers, json=payload)
    return response.json()

    def get_full_report(student_number):
    response = requests.get(f"{LARAVEL_API_URL}/student/full-report/Class_A/{student_number}")
    if response.status_code == 200:
        data = response.json()
        report_summary = "Taarifa Kamili za Mwanafunzi:\n\n"
        
        # Student Details
        report_summary += "Taarifa za Msingi:\n"
        report_summary += f"- Namba ya Mwanafunzi: {data['student_details']['student_number']}\n"
        report_summary += f"- Jina la Mwanafunzi: {data['student_details']['student_name']}\n"
        report_summary += f"- Jinsia: {data['student_details']['gender']}\n"
        report_summary += f"- Tarehe ya Kuzaliwa: {data['student_details']['date_of_birth']}\n"
        report_summary += f"- Kundi la Damu: {data['student_details']['blood_group']}\n"
        report_summary += f"- Jina la Mzazi: {data['student_details']['parent_name']}\n"
        report_summary += f"- Namba ya Mzazi: {data['student_details']['parent_number']}\n"
        report_summary += f"- Barua Pepe ya Mzazi: {data['student_details']['parent_email']}\n"
        report_summary += f"- Uhusiano: {data['student_details']['relationship']}\n\n"

        # Marks
        if data['marks']:
            report_summary += "Matokeo ya Mwanafunzi:\n"
            report_summary += f"- Sayansi: {data['marks']['subject_1']}\n"
            report_summary += f"- Hisabati: {data['marks']['subject_2']}\n"
            report_summary += f"- English: {data['marks']['subject_3']}\n"
            report_summary += f"- Jumla ya Alama: {data['marks']['total_marks']}\n"
            report_summary += f"- Wastani: {data['marks']['average_marks']}\n"
            report_summary += f"- Nafasi: {data['marks']['position']}\n\n"
        else:
            report_summary += "Matokeo hayajapatiwa.\n\n"

        # Payments
        if data['payments']:
            report_summary += "Malipo ya Mwanafunzi:\n"
            for payment in data['payments']:
                report_summary += f"- {payment['payment_type']}: {payment['amount']}\n"
        else:
            report_summary += "Hakuna malipo yaliyopatikana.\n"

        return report_summary
    else:
        return "Samahani, taarifa za mwanafunzi haziwezi kupatikana kwa sasa."

if __name__ == '__main__':
    app.run(port=5000)
    #EAANn64yDGEkBO2xfYM9l4UrfxsVpYqXQdZCgtoaWvdCblF9DFXmWXCYmcfpylfjr1TFhaCiTQIqmGiNWfxh8lPD2R8bwP5EgQ8046hwZBvC3qC3C4nlKvKmFlGWZBZAaQ4IugcmRIQbCLpgjZCwX6ZCEdDQZC2LWH6JI0Hn1zn1p2nd0BEEIzZA4cGXImHNxtzRhsZATszd9TJ71ziriT2xn31yMINqh3