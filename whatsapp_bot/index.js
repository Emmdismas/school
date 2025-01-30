import makeWASocket from "@whiskeysockets/baileys";
import * as baileys from "@whiskeysockets/baileys";
import { join, dirname } from "path";
import { fileURLToPath } from "url";

// Fix ya kupata `__dirname`
const __dirname = dirname(fileURLToPath(import.meta.url));

// Tumia `default export` kwa `useSingleFileAuthState`
const useSingleFileAuthState = baileys.default.useSingleFileAuthState;
const { state, saveState } = useSingleFileAuthState(join(__dirname, "auth_info.json"));

async function connectToWhatsApp() {
    const sock = makeWASocket({
        auth: state,
        printQRInTerminal: true,
    });

    sock.ev.on("creds.update", saveState);
    sock.ev.on("messages.upsert", async (msg) => {
        const message = msg.messages[0];
        if (!message.message || message.key.fromMe) return;

        const sender = message.key.remoteJid;
        const text = message.message.conversation || message.message.extendedTextMessage?.text;

        console.log("📩 New Message:", text);

        let reply = "Samahani, siwezi kuelewa. Tafadhali jaribu tena.";
        if (text.toLowerCase().includes("hi") || text.toLowerCase().includes("habari")) {
            reply = "Salam! Karibu, ninaweza kusaidia na taarifa zifuatazo:\n1. Mahudhurio\n2. Matokeo ya mitihani\n3. Malipo\n4. Assignment";
        }

        await sock.sendMessage(sender, { text: reply });
    });
}

connectToWhatsApp();
