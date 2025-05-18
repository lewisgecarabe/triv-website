<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIV Design and Construction - Careers</title>
    <style>
        :root {
            --primary: #d2153d;
            --secondary: #16213e;
            --tertiary: #3e0000;
            --neutral: #41444b;
            --light-gray: #f5f5f5;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-gray);
            color: var(--neutral);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header styles */
        header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary);
            margin-left: 10px;
        }

        .logo-text span {
            color: var(--secondary);
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--neutral);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: var(--primary);
        }

        nav ul li a.active {
            color: var(--primary);
            position: relative;
        }

        nav ul li a.active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: var(--primary);
            bottom: -5px;
            left: 0;
        }

        /* Hero section */
        .hero {
            background: linear-gradient(rgba(22, 33, 62, 0.8), rgba(22, 33, 62, 0.8)), url('/api/placeholder/1200/500') no-repeat center center;
            background-size: cover;
            color: var(--white);
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #b01232;
        }

        /* Jobs section */
        .jobs-section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 36px;
            color: var(--secondary);
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            width: 70px;
            height: 4px;
            background-color: var(--primary);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .job-card {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .job-header {
            padding: 20px;
            background-color: var(--secondary);
            color: var(--white);
        }

        .job-title {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .job-meta {
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .job-location {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .job-type {
            display: flex;
            align-items: center;
            background-color: var(--primary);
            padding: 3px 10px;
            border-radius: 15px;
        }

        .job-body {
            padding: 20px;
        }

        .job-description {
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .job-card .btn {
            font-size: 14px;
            padding: 8px 20px;
        }

        /* Job detail modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: var(--white);
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .close-btn {
            color: var(--neutral);
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: var(--primary);
        }

        .modal-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-title {
            color: var(--secondary);
            font-size: 30px;
            margin-bottom: 10px;
        }

        .modal-subtitle {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 16px;
        }

        .modal-subtitle span {
            display: flex;
            align-items: center;
        }

        .modal-subtitle i {
            margin-right: 8px;
        }

        .modal-body h3 {
            color: var(--secondary);
            margin: 25px 0 15px;
            font-size: 20px;
        }

        .requirements-list,
        .responsibilities-list {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .requirements-list li,
        .responsibilities-list li {
            margin-bottom: 10px;
        }

        .apply-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
        }

        /* Application form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--secondary);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .file-input-label {
            display: inline-block;
            padding: 12px 20px;
            background-color: var(--secondary);
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .file-input-label:hover {
            background-color: #111c33;
        }

        .file-name {
            margin-left: 10px;
            font-size: 14px;
        }

        .submit-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #b01232;
        }

        /* Why join us section */
        .why-join-us {
            padding: 80px 0;
            background-color: var(--white);
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .benefit-card {
            background-color: var(--light-gray);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .benefit-card:hover {
            transform: translateY(-10px);
        }

        .benefit-icon {
            width: 70px;
            height: 70px;
            background-color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--white);
            font-size: 30px;
        }

        .benefit-title {
            font-size: 20px;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        /* Footer */
        footer {
            background-color: var(--secondary);
            color: var(--white);
            padding: 60px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background-color: var(--primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #b4b8c0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .contact-info div {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .contact-info i {
            margin-right: 10px;
            color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            color: #b4b8c0;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                margin-top: 20px;
                justify-content: center;
            }

            nav ul li {
                margin: 0 10px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 18px;
            }

            .jobs-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .modal-content {
                width: 95%;
                margin: 10% auto;
                padding: 20px;
            }
        }

        /* Success message */
        .success-message {
            display: none;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <div class="logo-text">TRIV <span>Design & Construction</span></div>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Projects</a></li>
                    <li><a href="#" class="active">Careers</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Build Your Career With Us</h1>
            <p>Join our team of passionate architects, engineers, and construction professionals shaping the future landscape of the Philippines.</p>
            <a href="#jobs" class="btn">View Open Positions</a>
        </div>
    </section>

    <!-- Jobs Section -->
    <section id="jobs" class="jobs-section">
        <div class="container">
            <div class="section-title">
                <h2>Open Positions</h2>
            </div>
            
            <div class="jobs-grid">
                <!-- Job Card 1 -->
                <div class="job-card">
                    <div class="job-header">
                        <h3 class="job-title">Senior Architect</h3>
                        <div class="job-meta">
                            <div class="job-location">
                                <span>Manila, Philippines</span>
                            </div>
                            <div class="job-type">
                                <span>Full-time</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="job-description">
                            We're looking for a Senior Architect to lead design projects for commercial and residential buildings. You'll collaborate with clients and manage project teams to deliver innovative and sustainable architectural solutions.
                        </p>
                        <button class="btn view-job" data-job-id="1">View Details</button>
                    </div>
                </div>

                <!-- Job Card 2 -->
                <div class="job-card">
                    <div class="job-header">
                        <h3 class="job-title">Structural Engineer</h3>
                        <div class="job-meta">
                            <div class="job-location">
                                <span>Quezon City, Philippines</span>
                            </div>
                            <div class="job-type">
                                <span>Full-time</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="job-description">
                            Join our engineering team to analyze and design structural systems for buildings, ensuring they meet safety requirements and architectural vision while optimizing material usage and cost.
                        </p>
                        <button class="btn view-job" data-job-id="2">View Details</button>
                    </div>
                </div>

                <!-- Job Card 3 -->
                <div class="job-card">
                    <div class="job-header">
                        <h3 class="job-title">Project Manager</h3>
                        <div class="job-meta">
                            <div class="job-location">
                                <span>Makati, Philippines</span>
                            </div>
                            <div class="job-type">
                                <span>Full-time</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="job-description">
                            Oversee construction projects from inception to completion, coordinating with clients, architects, engineers, and contractors to ensure projects are completed on time, within budget, and to quality standards.
                        </p>
                        <button class="btn view-job" data-job-id="3">View Details</button>
                    </div>
                </div>

                <!-- Job Card 4 -->
                <div class="job-card">
                    <div class="job-header">
                        <h3 class="job-title">Interior Designer</h3>
                        <div class="job-meta">
                            <div class="job-location">
                                <span>Pasig, Philippines</span>
                            </div>
                            <div class="job-type">
                                <span>Full-time</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="job-description">
                            Create functional and aesthetically pleasing interior spaces that complement our architectural designs. Work with clients to understand their needs and transform spaces into beautiful, practical environments.
                        </p>
                        <button class="btn view-job" data-job-id="4">View Details</button>
                    </div>
                </div>

                <!-- Job Card 5 -->
                <div class="job-card">
                    <div class="job-header">
                        <h3 class="job-title">CAD Technician</h3>
                        <div class="job-meta">
                            <div class="job-location">
                                <span>Taguig, Philippines</span>
                            </div>
                            <div class="job-type">
                                <span>Full-time</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="job-description">
                            Support our design team by creating detailed technical drawings and 3D models using AutoCAD, Revit, and other design software. Convert conceptual designs into technical specifications for construction.
                        </p>
                        <button class="btn view-job" data-job-id="5">View Details</button>
                    </div>
                </div>

                <!-- Job Card 6 -->
                <div class="job-card">
                    <div class="job-header">
                        <h3 class="job-title">Civil Engineer</h3>
                        <div class="job-meta">
                            <div class="job-location">
                                <span>Alabang, Philippines</span>
                            </div>
                            <div class="job-type">
                                <span>Full-time</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-body">
                        <p class="job-description">
                            Design, develop, and supervise infrastructure projects including site development, drainage systems, roads, and utilities. Ensure compliance with building codes and environmental regulations.
                        </p>
                        <button class="btn view-job" data-job-id="6">View Details</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join Us Section -->
    <section class="why-join-us">
        <div class="container">
            <div class="section-title">
                <h2>Why Join TRIV?</h2>
            </div>
            
            <div class="benefits-grid">
                <!-- Benefit 1 -->
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <span>★</span>
                    </div>
                    <h3 class="benefit-title">Career Growth</h3>
                    <p>Develop your professional skills with mentorship programs and continuous learning opportunities.</p>
                </div>

                <!-- Benefit 2 -->
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <span>✓</span>
                    </div>
                    <h3 class="benefit-title">Innovative Projects</h3>
                    <p>Work on diverse, cutting-edge projects that challenge your creativity and technical skills.</p>
                </div>

                <!-- Benefit 3 -->
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <span>♥</span>
                    </div>
                    <h3 class="benefit-title">Work-Life Balance</h3>
                    <p>Flexible work arrangements and comprehensive benefits to support your well-being.</p>
                </div>

                <!-- Benefit 4 -->
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <span>⚡</span>
                    </div>
                    <h3 class="benefit-title">Collaborative Culture</h3>
                    <p>Join a supportive team that values communication, diversity, and shared success.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>About TRIV</h3>
                    <p>TRIV Design and Construction is a leading architectural and construction firm in the Philippines, committed to creating innovative, sustainable, and functional spaces.</p>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <div class="contact-info">
                        <div>
                            <i>📍</i>
                            <p>123 Corporate Avenue, Makati City, Philippines</p>
                        </div>
                        <div>
                            <i>📞</i>
                            <p>+63 2 8123 4567</p>
                        </div>
                        <div>
                            <i>✉️</i>
                            <p>careers@trivdesign.com</p>
                        </div>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Follow Us</h3>
                    <ul class="footer-links">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">LinkedIn</a></li>
                        <li><a href="#">Twitter</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 TRIV Design and Construction. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Job Detail Modal -->
    <div id="jobModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            
            <div class="modal-header">
                <h2 class="modal-title" id="jobTitle">Senior Architect</h2>
                <div class="modal-subtitle">
                    <span id="jobLocation">Manila, Philippines</span>
                    <span id="jobType">Full-time</span>
                    <span id="jobSalary">₱80,000 - ₱120,000 per month</span>
                </div>
            </div>
            
            <div class="modal-body">
                <div id="jobDescription">
                    <p>As a Senior Architect at TRIV Design and Construction, you will lead architectural design projects, collaborate with clients, and mentor junior team members. You'll be responsible for creating innovative, sustainable, and functional designs that meet client needs and regulatory requirements.</p>
                </div>
                
                <h3>Responsibilities:</h3>
                <ul class="responsibilities-list" id="jobResponsibilities">
                    <li>Lead and manage architectural design projects from concept to completion</li>
                    <li>Collaborate with clients to understand their requirements and translate them into design solutions</li>
                    <li>Develop detailed design presentations and documentation</li>
                    <li>Ensure designs comply with building codes, zoning regulations, and sustainability standards</li>
                    <li>Coordinate with engineers, contractors, and other consultants</li>
                    <li>Mentor and supervise junior architects and designers</li>
                    <li>Participate in business development and client relationship management</li>
                </ul>
                
                <h3>Requirements:</h3>
                <ul class="requirements-list" id="jobRequirements">
                    <li>Bachelor's or Master's degree in Architecture</li>
                    <li>Licensed architect in the Philippines</li>
                    <li>Minimum of 7 years of professional experience in architectural design</li>
                    <li>Proficiency in AutoCAD, Revit, SketchUp, and other architectural software</li>
                    <li>Strong portfolio demonstrating design excellence and technical knowledge</li>
                    <li>Excellent communication and leadership skills</li>
                    <li>Experience with sustainable design principles and practices</li>
                </ul>

                <div class="apply-section">
                    <h3>Apply for this Position</h3>
                    <form id="applicationForm">
                        <input type="hidden" id="applyJobId" value="1">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Current Address</label>
                            <input type="text" id="address" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="education">Highest Educational Attainment *</label>
                            <input type="text" id="education" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="experience">Years of Experience *</label>
                            <input type="number" id="experience" class="form-control" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Upload Resume/CV (PDF, DOC, DOCX) *</label>
                            <div class="file-input-wrapper">
                                <label class="file-input-label">Choose File</label>
                                <input type="file" id="resume" class="file-input" accept=".pdf,.doc,.docx" required>
                                <span class="file-name" id="fileName">No file chosen</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="coverLetter">Cover Letter</label>
                            <textarea id="coverLetter" class="form-control" rows="