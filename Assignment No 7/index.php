<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIT Semester Result System</title>
    
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- React & Babel CDNs -->
    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="style.css">
    
    <style>
        /* Loading animation style */
        .loading { font-size: 1.5rem; color: #1a237e; text-align: center; margin-top: 50px; font-weight: 700; }
    </style>
</head>
<body>

    <div id="root">
        <div class="loading">Initializing VIT Result Portal...</div>
    </div>

    <!-- React Application Logic -->
    <script type="text/babel">
        const { useState, useEffect } = React;

        /**
         * Result Component (Child of Student)
         * - Receives weighted scores and determines status
         */
        const Result = ({ subjects }) => {
            const calculateFinal = (mse, ese) => (mse * 30 / 30) + (ese * 70 / 70); // Logic: (MSE out of 30) * 0.3 is MSE marks. But normally MSE is 30 marks and weighted at 30%. ESE is 70 marks and weighted at 70%.
            // If MSE is 30, it accounts for 30%. If ESE is 70, it accounts for 70%. 
            // So Final = MSE + ESE (Since 30 + 70 = 100).
            
            const results = subjects.map(s => {
                const total = s.mse + s.ese;
                return { name: s.name, total, pass: total >= 40 };
            });

            const overallPass = results.every(r => r.pass);
            const average = results.reduce((acc, curr) => acc + curr.total, 0) / results.length;

            return (
                <div className="result-display">
                    <div className={`status-badge ${overallPass ? 'status-pass' : 'status-fail'}`}>
                        {overallPass ? 'PROMOTED / PASS' : 'FAILED / RE-EXAM'}
                    </div>
                    <div className="final-score">
                        {average.toFixed(2)}%
                    </div>
                    <p style={{fontSize: '0.8rem', color: '#888'}}>Weighted Average (MSE 30% + ESE 70%)</p>
                </div>
            );
        };

        /**
         * Student Component (Child of App)
         * - Manages individual student marks as state
         */
        const Student = ({ id, name, course, initialMarks }) => {
            const [marks, setMarks] = useState(initialMarks);

            const handleMarkChange = (subject, type, value) => {
                const numericValue = Math.min(Math.max(0, parseInt(value) || 0), type === 'mse' ? 30 : 70);
                setMarks(prev => ({
                    ...prev,
                    [subject]: { ...prev[subject], [type]: numericValue }
                }));
            };

            const subjectList = [
                { id: 'wt', name: 'Web Technology' },
                { id: 'os', name: 'Operating Systems' },
                { id: 'ai', name: 'Artificial Intelligence' },
                { id: 'dbms', name: 'Database Management' }
            ];

            return (
                <div className="student-card">
                    <div className="card-header">
                        <div className="student-info">
                            <h2>{name}</h2>
                            <p style={{margin: '5px 0', color: '#666'}}>ID: 2026VIT{id.toString().padStart(3, '0')}</p>
                        </div>
                        <span className="course-tag">{course}</span>
                    </div>

                    <div className="marks-grid">
                        {subjectList.map(sub => (
                            <div key={sub.id} className="subject-box">
                                <span className="subject-name">{sub.name}</span>
                                <div className="marks-input-group">
                                    <div>
                                        <label>MSE (30)</label>
                                        <input 
                                            type="number" 
                                            value={marks[sub.id].mse} 
                                            onChange={(e) => handleMarkChange(sub.id, 'mse', e.target.value)}
                                        />
                                    </div>
                                    <div>
                                        <label>ESE (70)</label>
                                        <input 
                                            type="number" 
                                            value={marks[sub.id].ese} 
                                            onChange={(e) => handleMarkChange(sub.id, 'ese', e.target.value)}
                                        />
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    <Result subjects={subjectList.map(s => ({ name: s.name, mse: marks[s.id].mse, ese: marks[s.id].ese }))} />
                </div>
            );
        };

        /**
         * App Component (Parent)
         * - Fetches data and manages the list of students
         */
        const App = () => {
            const [students, setStudents] = useState([]);
            const [loading, setLoading] = useState(true);

            useEffect(() => {
                const sampleData = [
                    { id: 1, name: "Satya Nadella", course: "B.Tech IT", marks: { wt: { mse: 25, ese: 65 }, os: { mse: 28, ese: 60 }, ai: { mse: 22, ese: 55 }, dbms: { mse: 26, ese: 68 } } },
                    { id: 2, name: "Sundar Pichai", course: "B.Tech CSE", marks: { wt: { mse: 29, ese: 68 }, os: { mse: 27, ese: 62 }, ai: { mse: 24, ese: 58 }, dbms: { mse: 28, ese: 64 } } },
                    { id: 3, name: "Sam Altman", course: "B.Tech AI-DS", marks: { wt: { mse: 15, ese: 30 }, os: { mse: 18, ese: 35 }, ai: { mse: 12, ese: 25 }, dbms: { mse: 20, ese: 28 } } }
                ];

                fetch('api.php')
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const formatted = data.map(s => ({
                                id: s.id,
                                name: s.student_name,
                                course: s.course,
                                marks: {
                                    wt: { mse: parseInt(s.wt_mse) || 0, ese: parseInt(s.wt_ese) || 0 },
                                    os: { mse: parseInt(s.os_mse) || 0, ese: parseInt(s.os_ese) || 0 },
                                    ai: { mse: parseInt(s.ai_mse) || 0, ese: parseInt(s.ai_ese) || 0 },
                                    dbms: { mse: parseInt(s.dbms_mse) || 0, ese: parseInt(s.dbms_ese) || 0 }
                                }
                            }));
                            setStudents(formatted);
                        } else {
                            setStudents(sampleData);
                        }
                        setLoading(false);
                    })
                    .catch(err => {
                        console.warn("API Error, using fallback:", err);
                        setStudents(sampleData);
                        setLoading(false);
                    });
            }, []);

            if (loading) return <div className="loading">Connecting to Student Database...</div>;

            return (
                <div className="container">
                    <header>
                        <h1>VIT Semester Result Portal</h1>
                        <p className="subtitle">School of Computer Engineering & IT</p>
                    </header>
                    
                    <main>
                        {students.length > 0 ? (
                            students.map(student => (
                                <Student 
                                    key={student.id}
                                    id={student.id}
                                    name={student.name}
                                    course={student.course}
                                    initialMarks={student.marks}
                                />
                            ))
                        ) : (
                            <p style={{textAlign: 'center'}}>No student data found. Please check your MySQL table.</p>
                        )}
                    </main>

                    <footer style={{textAlign: 'center', marginTop: '50px', padding: '20px', borderTop: '1px solid #ddd', color: '#999', fontSize: '0.9rem'}}>
                        &copy; {new Date().getFullYear()} Vishwakarma Institute of Technology, Pune. Handcrafted with React & PHP.
                    </footer>
                </div>
            );
        };

        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);
    </script>
</body>
</html>
