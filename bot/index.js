const { default: makeWASocket, useSingleFileAuthState } = require('@whiskeysockets/baileys');
const { Boom } = require('@hapi/boom');
const qrcode = require('qrcode-terminal');
const axios = require('axios');

const { state, saveState } = useSingleFileAuthState('./auth_info.json');

const connectToWhatsApp = async () => {
    const sock = makeWASocket({
        auth: state,
        printQRInTerminal: true,
    });

    sock.ev.on('creds.update', saveState);

    sock.ev.on('messages.upsert', async (msg) => {
        const message = msg.messages[0];
        if (!message.message) return;

        const sender = message.key.remoteJid;
        const text = message.message.conversation || message.message.extendedTextMessage?.text;

        console.log(`Message from ${sender}: ${text}`);

        // Fanya maombi ya Laravel kwa kutumia axios
        const response = await axios.post('http://localhost/api/webhook', {
            sender,
            text,
        });

        // Jibu kwa ujumbe
        await sock.sendMessage(sender, { text: response.data.reply });
    });
};

connectToWhatsApp();
