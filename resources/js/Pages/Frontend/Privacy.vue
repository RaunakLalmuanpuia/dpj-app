<template>
    <div class="privacy-policy-container">
        <header class="policy-header">
            <h1>Privacy Policy</h1>
            <p class="subtitle">KeyTagJo</p>
            <p class="last-updated">Last updated: August 8, 2025</p>
        </header>

        <main class="policy-content">
            <section class="intro">
                <p>
                    This Privacy Policy explains how <strong>EIGHTSIS TECH PRIVATE LIMITED</strong> collects,
                    uses, and protects your information when you use our website or services.
                </p>
            </section>

            <section>
                <h2>Information We Collect</h2>
                <ul>
                    <li>Name and contact details such as email address and phone number.</li>
                    <li>Demographic information including postcode, preferences, and interests (if required).</li>
                    <li>Other details relevant to customer surveys, offers, and service improvements.</li>
                </ul>
            </section>

            <section>
                <h2>How We Use the Information</h2>
                <ul>
                    <li>To maintain internal records and improve our products and services.</li>
                    <li>To send periodic promotional emails about new products, special offers, or updates using the email you provide.</li>
                    <li>To contact you for market research purposes via email, phone, or mail.</li>
                    <li>To customize our website and services according to your interests.</li>
                </ul>
            </section>

            <section>
                <h2>Information Sharing and Disclosure</h2>
                <ul>
                    <li>We do not sell, distribute, or lease your personal information to third parties unless required by law or with your permission.</li>
                    <li>We may share promotional information about third parties if you have agreed to receive such communications.</li>
                    <li>Your information may be disclosed to comply with legal obligations or to protect our rights and security.</li>
                </ul>
            </section>

            <section>
                <h2>Data Security</h2>
                <ul>
                    <li>We are committed to keeping your information secure.</li>
                    <li>Appropriate technical and organizational measures are in place to prevent unauthorized access or disclosure.</li>
                    <li>We regularly review and update our security practices to safeguard your data.</li>
                </ul>
            </section>

            <section>
                <h2>Your Rights and Choices</h2>
                <ul>
                    <li>You can choose to restrict the collection or use of your personal information at any time.</li>
                    <li>If you previously agreed to direct marketing, you can withdraw consent by contacting us at <a href="mailto:contact@eightsis.com">contact@eightsis.com</a>.</li>
                    <li>You have the right to request corrections if any of your personal data is incorrect or incomplete.</li>
                    <li>We will promptly update or delete information at your request in line with applicable laws.</li>
                </ul>
            </section>

            <section>
                <h2>Cookies and Tracking</h2>
                <ul>
                    <li>We use cookies to enhance your browsing experience and maintain session functionality.</li>
                    <li>Traffic log cookies help us analyze which pages are most useful for improving our website.</li>
                    <li>Cookies do not give us access to your computer or any information other than what you choose to share.</li>
                    <li>You can accept or decline cookies in your browser settings, but some features may not work properly if disabled.</li>
                </ul>
            </section>

            <section class="contact-section">
                <h2>Contact Us</h2>
                <p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>
                <div class="contact-details">
                    <p><strong>Email:</strong> <a href="mailto:contact@eightsis.com">contact@eightsis.com</a></p>
                    <p><strong>Address:</strong> 2nd Floor, JL Building, Mission Veng, Aizawl, Mizoram 796005</p>
                    <p><strong>Phone:</strong> <a href="tel:+919748864995">+91 9748864995</a></p>
                </div>
            </section>

            <section class="policy-updates">
                <h2>Policy Updates</h2>
                <p>
                    EIGHTSIS TECH PRIVATE LIMITED may update this Privacy Policy from time to time.
                    We recommend reviewing this page periodically to ensure you are aware of any changes.
                    Your continued use of our services will be considered as acceptance of the updated Privacy Policy.
                </p>
            </section>
        </main>
    </div>
</template>

<script setup>
// No script logic is strictly required for this static content,
// but you can add meta tags (using vue-meta or similar) here if needed.
</script>

<style scoped>
.privacy-policy-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #333;
    line-height: 1.6;
}

.policy-header {
    text-align: center;
    margin-bottom: 40px;
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 20px;
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.subtitle {
    font-size: 1.2rem;
    font-weight: 600;
    color: #42b983; /* Vue Green */
    margin: 0;
}

.last-updated {
    color: #666;
    font-size: 0.9rem;
    margin-top: 10px;
}

section {
    margin-bottom: 30px;
}

h2 {
    font-size: 1.5rem;
    color: #2c3e50;
    margin-bottom: 15px;
    border-left: 4px solid #42b983;
    padding-left: 10px;
}

ul {
    padding-left: 20px;
}

li {
    margin-bottom: 10px;
}

a {
    color: #42b983;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.contact-section {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
}

.contact-details p {
    margin: 5px 0;
}

.policy-updates {
    border-top: 1px solid #eaeaea;
    padding-top: 20px;
    font-style: italic;
    color: #555;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .privacy-policy-container {
        padding: 20px 15px;
    }

    h1 {
        font-size: 2rem;
    }
}
</style>
