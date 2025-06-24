const { default: makeWASocket, useSingleFileAuthState, DisconnectReason } = require("@whiskeysockets/baileys");
const { Boom } = require('@hapi/boom');
const qrcode = require('qrcode-terminal');
const axios = require('axios');
const fs = require('fs');

const { state, saveState } = useSingleFileAuthState('./auth.json');

async function startBot() {
    const sock = makeWASocket({
        auth: state,
        printQRInTerminal: true,
    });

    sock.ev.on('creds.update', saveState);

    sock.ev.on('messages.upsert', async ({ messages, type }) => {
        const msg = messages[0];
        if (!msg.message || msg.key.fromMe) return;

        const sender = msg.key.remoteJid;
        const text = msg.message.conversation || msg.message.extendedTextMessage?.text;

        if (!text) return;

        if (text.toLowerCase().startsWith('matokeo')) {
            const parts = text.split(' ');
            const studentId = parts[1];

            try {
                const response = await axios.get(`http://localhost:8000/api/results/${studentId}`);
                const result = response.data;

                await sock.sendMessage(sender, { text: `📊 Matokeo ya mwanafunzi:\n${JSON.stringify(result, null, 2)}` });
            } catch (err) {
                await sock.sendMessage(sender, { text: "❌ Samahani, hatukuweza kupata matokeo. Hakikisha ID iko sawa." });
            }
        }

        // More commands like attendance, ada etc can be added here
    });

    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect } = update;
        if (connection === 'close') {
            const shouldReconnect = (lastDisconnect.error = new Boom(lastDisconnect?.error))?.output?.statusCode !== DisconnectReason.loggedOut;
            console.log('Connection closed. Reconnecting:', shouldReconnect);
            if (shouldReconnect) {
                startBot();
            }
        } else if (connection === 'open') {
            console.log('✅ WhatsApp Bot connected!');
        }
    });
}

startBot();
