def respond(message):
    message_lower = message.lower()

    # 1. Maneno mabaya
    if any(bad_word in message_lower for bad_word in bad_words):
        return "😊 Tafadhali tutumie lugha nzuri, niko hapa kukusaidia kwa hali yoyote."

    # 2. Vicheko
    if "😂" in message or "😆" in message:
        return "Hahaha! Nashukuru kwa vicheko! 😄 Sasa tuendelee, unahitaji nini?"

    # 3. Salamu za kirafiki
    if "habari uko poa" in message_lower or "uko poa" in message_lower:
        state["stage"] = "ask_need"
        return "Niko poa kabisa, asante kwa kuuliza! 😊 Mimi ni AlphaForce – unaweza kuniita Alpha. Nikusaidie nini? (matokeo, ada, attendance, assignments, mzazi, au taarifa nyingine?)"

    if "wewe ni nani" in message_lower:
        return "Mimi ni AlphaForce – unaweza kuniita Alpha. Ni furaha kukusaidia kupata taarifa mbalimbali za mwanafunzi."

    # 4. Emergency
   elif state["stage"] == "ask_emergency_student":
    name = message.strip()
    state["emergency_student_name"] = name

    response = requests.post(f"{BASE_URL}/student/teacher-contact", json={"name": name})
    if response.status_code == 200:
        contact = response.json()

        # Log dharura
        requests.post(f"{BASE_URL}/student/emergency-log", json={
            "narrative": state.get("emergency_narrative"),
            "student_name": name,
            "timestamp": datetime.now().isoformat()
        })

        # Send notification kwa mzazi na mwalimu
        emergency_message = (
            f"🚨 DHARURA: Kuna tukio la dharura kwa mwanafunzi {name}.\n"
            f"Tukio: {state.get('emergency_narrative')}\n"
            f"Tafadhali chukua hatua haraka!"
        )

        # Tuma SMS au WhatsApp kwa mzazi
        requests.post(f"{BASE_URL}/notify/sms", json={
            "phone": contact['parent_phone'],
            "message": emergency_message
        })

        # Tuma SMS au WhatsApp kwa mwalimu
        requests.post(f"{BASE_URL}/notify/sms", json={
            "phone": contact['teacher_phone'],
            "message": emergency_message
        })

        state["stage"] = "final"
        return (
            f"📍 {name} amepatikana.\n"
            f"Mwalimu wa darasa: {contact['teacher_name']}\n"
            f"Namba ya simu: {contact['teacher_phone']}\n\n"
            "✅ Taarifa ya dharura imetumwa kwa mzazi na mwalimu wa darasa. Tafadhali fuatilia kwa haraka."
        )
    else:
        return "Samahani, mwanafunzi huyu hajulikani. Tafadhali andika jina sahihi."

    # 5. Mwanzo wa mazungumzo
    if state["stage"] == "start":
        if any(word in message_lower for word in salamu):
            state["stage"] = "ask_need"
            return "Habari! Mimi ni AlphaForce – unaweza kuniita Alpha. Nikusaidie nini? (matokeo, ada, attendance, assignments au taarifa za mwanafunzi?)"

    # 6. Kuuliza aina ya taarifa
    elif state["stage"] == "ask_need":
        state["need"] = message_lower
        state["stage"] = "ask_name"
        return "Sawa, tafadhali ingiza jina kamili au namba ya mwanafunzi (mfano: EMMANUEL DISMAS ABDALLAH)."

    # 7. Kuangalia jina la mwanafunzi
    elif state["stage"] == "ask_name":
        name = message.strip()
        response = requests.post(f"{BASE_URL}/student/verify-name", json={"name": name})
        if response.status_code == 200:
            state["student_name"] = name
            state["stage"] = "ask_password"
            return f"Asante. {name} amepatikana. Tafadhali ingiza **password** ya mwanafunzi."
        else:
            return "Mwanafunzi hajulikani. Tafadhali andika jina vizuri kama lilivyoandikishwa."

    # 8. Kuangalia password
    elif state["stage"] == "ask_password":
        password = message.strip()
        name = state["student_name"]
        response = requests.post(f"{BASE_URL}/student/verify-password", json={"name": name, "password": password})
        if response.status_code == 200:
            state["authenticated"] = True
            state["stage"] = "show_info"
            return f"Umefanikiwa kuingia. Unaomba taarifa za {state['need']} sasa hivi..."
        else:
            return "Password si sahihi. Tafadhali jaribu tena au bonyeza hapa kurekebisha: https://yourdomain.com/recover-password"

    # 9. Onyesha taarifa (matokeo, ada, mzazi n.k.)
    elif state["stage"] == "show_info":
        name = state['student_name']
        
        # Matokeo
        if state["need"] == "matokeo":
            res = requests.get(f"{BASE_URL}/student/exam-results", params={"name": name})
            if res.status_code == 200:
                results = res.json()
                msg = f"📊 *Matokeo ya {name}*:\n"
                total = 0
                fail_subjects = []

                for subject, mark in results.items():
                    msg += f"📝 {subject}: {mark}\n"
                    total += mark
                    if mark < 40:
                        fail_subjects.append(subject)

                avg = total / len(results)

                # Maoni ya kiutu
                msg += f"\n📈 *Average*: {round(avg, 1)}%\n"
                if avg >= 70:
                    msg += "🎉 Hongera sana! Umefanya vizuri kwenye mitihani yako. Endelea hivyo hivyo! 💪"
                elif len(fail_subjects) == 1:
                    msg += f"🙂 Umejitahidi! Lakini zingatia zaidi somo la {fail_subjects[0]} ili uboreshe matokeo yako."
                elif len(fail_subjects) > 1:
                    msg += f"⚠️ Kuna changamoto kwenye masomo yafuatayo: {', '.join(fail_subjects)}. Tafadhali ongea na walimu wakusaidie zaidi."

                state["stage"] = "final"
                return msg + "\n\nUnahitaji msaada mwingine?"
            else:
                return "Samahani, hatukuweza kupata matokeo kwa sasa."

        # Ada
        elif state["need"] == "ada":
            res = requests.get(f"{BASE_URL}/student/fees", params={"name": name})
            if res.status_code == 200:
                data = res.json()
                status = data["status"]
                amount = data["amount_due"]
                if status == "paid":
                    return f"✅ Ada ya {name} imelipwa kikamilifu. Asante kwa kufuata taratibu!"
                else:
                    return f"⚠️ Ada haijakamilika bado. Bado unadaiwa Tsh {amount}. Tafadhali lipa mapema kuepuka usumbufu wa huduma za shule kusitishwa."
            else:
                return "Samahani, hatukuweza kupata taarifa za ada."

        # Taarifa za mzazi/afya
        elif state["need"] == "mzazi" or "blood" in state["need"]:
            if state["authenticated"]:
                res = requests.get(f"{BASE_URL}/student/emergency-details", params={"name": name})
                if res.status_code == 200:
                    data = res.json()
                    return (f"📍 Taarifa za afya za {name}:\n"
                            f"Namba ya mzazi: {data['parent_phone']}\n"
                            f"Blood group: {data['blood_group']}\n"
                            "Tafadhali wasiliana nao kwa haraka endapo ni emergency.")
                else:
                    return "Samahani, hatukuweza kupata taarifa za afya kwa sasa."
            else:
                return "Tafadhali ingiza password kwanza ili kupata taarifa za afya au mzazi."

    # 10. Final – aulizwe kama anataka kitu kingine
    elif state["stage"] == "final":
        if "ndio" in message_lower:
            state["stage"] = "ask_need"
            return "Sawa, unahitaji nini sasa? (matokeo, ada, attendance, assignments, mzazi, blood group, au taarifa nyingine?)"
        elif "hapana" in message_lower:
            return "Asante kwa kutumia Alpha. Kama kuna shida yoyote, wasiliana na mwalimu mkuu kwa namba 0699789593. 👋"
        else:
            return "Tafadhali jibu kwa kusema *ndio* au *hapana*."

    return "Samahani, sikuelewa vizuri. Tafadhali rudia au eleza kwa njia nyingine."
