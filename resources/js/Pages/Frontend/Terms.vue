<template>
    <div class="terms-container">
        <header class="terms-header">
            <h1>Terms & Conditions</h1>
            <p class="subtitle">KeyTagJo</p>
            <p class="last-updated">Last updated: August 8, 2025</p>
        </header>

        <main class="terms-content">
            <section class="intro">
                <p>
                    These Terms and Conditions govern your use of the <strong>EIGHTSIS TECH PRIVATE LIMITED</strong> website and any purchases you make from us.
                </p>
            </section>

            <section>
                <h2>Overview & Acceptance</h2>
                <p>
                    For the purposes of these Terms and Conditions, “we”, “us”, and “our” refer to <strong>EIGHTSIS TECH PRIVATE LIMITED</strong>,
                    whose registered/operational office is 2nd Floor, JL Building, Mission Veng, Aizawl, Mizoram 796005.
                </p>
                <p>
                    “You”, “your”, “user”, and “visitor” refer to any person who visits our website and/or agrees to purchase from us.
                </p>
                <p>
                    By accessing our website and/or purchasing from us, you accept and agree to be bound by these Terms and Conditions.
                </p>
            </section>

            <section>
                <h2>Website Use & Changes</h2>
                <ul>
                    <li>The content of the pages of this website is subject to change without notice.</li>
                    <li>From time to time, our website may include links to other websites. These links are provided for your convenience to provide further information.</li>
                </ul>
            </section>

            <section>
                <h2>Warranty Disclaimer & Liability</h2>
                <ul>
                    <li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness, or suitability of information and materials found on this website for any particular purpose.</li>
                    <li>Such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
                    <li>Your use of any information or materials on our website and/or product pages is entirely at your own risk. It is your responsibility to ensure that products, services, or information available meet your specific requirements.</li>
                </ul>
            </section>

            <section>
                <h2>Intellectual Property & Trademarks</h2>
                <ul>
                    <li>This website contains material which is owned by or licensed to us, including but not limited to the design, layout, look, appearance, and graphics.</li>
                    <li>Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</li>
                    <li>All trademarks reproduced on this website which are not the property of, or licensed to, the operator are acknowledged on the website.</li>
                </ul>
            </section>

            <section>
                <h2>Unauthorized Use & Security</h2>
                <ul>
                    <li>Unauthorized use of information provided by us shall give rise to a claim for damages and/or be a criminal offense.</li>
                    <li>You may not create a link to our website from another website or document without EIGHTSIS TECH PRIVATE LIMITED’s prior written consent.</li>
                </ul>
            </section>

            <section>
                <h2>Your Responsibilities</h2>
                <ul>
                    <li>You are responsible for ensuring that any products, services, or information available through our website and/or product pages meet your specific requirements.</li>
                    <li>Any use of the website and purchases made are at your sole discretion and risk.</li>
                </ul>
            </section>

            <section>
                <h2>Transactions & Authorization</h2>
                <p>
                    We shall be under no liability whatsoever in respect of any loss or damage arising directly or indirectly out of the decline of authorization for any transaction, on account of the cardholder having exceeded the preset limit mutually agreed by us with our acquiring bank from time to time.
                </p>
            </section>

            <section>
                <h2>Governing Law & Jurisdiction</h2>
                <p>
                    Any dispute arising out of your use of our website and/or purchases with us and/or any engagement with us is subject to the laws of India.
                </p>
            </section>

            <section class="contact-section">
                <h2>Questions About These Terms?</h2>
                <p>If you have any questions about these Terms and Conditions, please contact us:</p>
                <div class="contact-details">
                    <p><strong>Email:</strong> <a href="mailto:contact@eightsis.com">contact@eightsis.com</a></p>
                    <p><strong>Address:</strong> 2nd Floor, JL Building, Mission Veng, Aizawl, Mizoram 796005</p>
                    <p><strong>Phone:</strong> <a href="tel:+919748864995">+91 9748864995</a></p>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
// No script logic strictly required for static content.
</script>

<style scoped>
.terms-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #333;
    line-height: 1.6;
}

.terms-header {
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

p {
    margin-bottom: 15px;
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
    margin-top: 40px;
}

.contact-details p {
    margin: 5px 0;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .terms-container {
        padding: 20px 15px;
    }

    h1 {
        font-size: 2rem;
    }
}
</style>
