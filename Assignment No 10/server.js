const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const cors = require('cors');
const path = require('path');

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(express.static('public'));

// MongoDB Connection
mongoose.connect('mongodb://127.0.0.1:27017/student_db')
  .then(() => console.log('MongoDB Connected'))
  .catch(err => console.log('Database Connection Error:', err));


// Student Schema
const StudentSchema = new mongoose.Schema({
    name: { type: String, required: true },
    email: { type: String, required: true, unique: true },
    course: { type: String, required: true }
});

const Student = mongoose.model('Student', StudentSchema);

// Routes
// 1. Insert new student record
app.post('/api/register', async (req, res) => {
    try {
        const { name, email, course } = req.body;
        const newStudent = new Student({ name, email, course });
        await newStudent.save();
        res.status(201).json({ message: 'Student registered successfully', student: newStudent });
    } catch (err) {
        res.status(400).json({ error: err.message });
    }
});

// 2. Retrieve all student records
app.get('/api/students', async (req, res) => {
    try {
        const students = await Student.find();
        res.status(200).json(students);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Start Server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
