// Import necessary modules
import express from 'express';  // Express framework for building web applications
import { createServer } from 'node:http';  // Node.js module for creating an HTTP server
import { fileURLToPath } from 'node:url';  // Utilities for working with file URLs
import { dirname, join } from 'node:path';  // Utilities for working with file and directory paths
import { Server } from 'socket.io';  // Socket.io library for enabling real-time web applications

// Initialize the Express application
const app = express();

// Create an HTTP server and attach the Express application to it
const server = createServer(app);

// Initialize Socket.io with the HTTP server
const io = new Server(server);

// Determine the directory name of the current module file
const __dirname = dirname(fileURLToPath(import.meta.url));

app.get('/', (req, res) => {
    res.sendFile(join(__dirname, 'send.html'));
});

app.get('/receive', (req, res) => {
    res.sendFile(join(__dirname, 'receive.html'));  // Send the index.html file to the client
});

io.on('connection', (socket) => {
    socket.on('data', (msg) => {
        // Broadcast the typing message to all connected clients
        // io.emit('data', msg);

        // Broadcast the typing message to all connected clients EXCEPT the sender.
        socket.broadcast.emit('data', msg);

    });
});


server.listen(3000, () => {
    console.log('Server running at http://localhost:3000');
});