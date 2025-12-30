<template>
    <div class="policy-container">
        <header class="policy-header">
            <h1>Cancellation & Refund Policy</h1>
            <p class="subtitle">KeyTagJo</p>
            <p class="intro-text">
                No cancellations & refunds are entertained for purchases or subscriptions.
            </p>
            <p class="last-updated">Last updated: August 8, 2025</p>
        </header>

        <main class="policy-content">

            <section class="steps-section">
                <h2>Before You Subscribe</h2>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h3>Review Plan Details</h3>
                        <p>Please verify features and pricing before purchase.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h3>Confirm Purchase</h3>
                        <p>Completing payment indicates acceptance of this policy.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h3>All Sales Are Final</h3>
                        <p>Cancellations and refunds are not available post-purchase.</p>
                    </div>
                </div>
                <div class="note-box">
                    <strong>Note:</strong> If you have questions before subscribing, please contact support for clarification. After payment, no cancellations or refunds are provided.
                </div>
            </section>

            <section class="eligibility-section">
                <h2>Refund Eligibility</h2>
                <p class="section-desc">The following scenarios are not eligible for cancellation or refund.</p>

                <div class="eligibility-grid">
                    <div class="eligibility-card">
                        <h3>All Sales Final</h3>
                        <p>No cancellations or refunds are offered for any purchases or subscriptions. All sales are final.</p>
                        <span class="badge">Not applicable</span>
                    </div>

                    <div class="eligibility-card">
                        <h3>Change of Mind</h3>
                        <p>Deciding not to use the service after purchase is not eligible for cancellation or refund.</p>
                        <span class="badge">No refund available</span>
                    </div>

                    <div class="eligibility-card">
                        <h3>Subscription Cancellation</h3>
                        <p>Subscriptions cannot be canceled once activated and billed.</p>
                        <span class="badge">No cancellation accepted</span>
                    </div>

                    <div class="eligibility-card">
                        <h3>Billing & Service Issues</h3>
                        <p>Payments already processed are non-refundable. For any concerns, contact support for assistance.</p>
                        <span class="badge">No refund available</span>
                    </div>
                </div>
            </section>

            <section class="process-section">
                <h2>Refund Process</h2>
                <div class="process-list">
                    <div class="process-item">
                        <h3>Policy</h3>
                        <p>We do not process cancellations or refunds. All payments are final.</p>
                    </div>
                    <div class="process-item">
                        <h3>Need Assistance?</h3>
                        <p>If you believe there's an issue with your account, contact support for guidance.</p>
                    </div>
                    <div class="process-item">
                        <h3>Payment Provider</h3>
                        <p>For payment concerns, you may also reach out to your payment provider for assistance.</p>
                    </div>
                </div>
            </section>

            <section class="notes-section">
                <h2>Important Notes</h2>
                <ul class="notes-list">
                    <li>All sales are final. No cancellations or refunds.</li>
                    <li>Subscriptions cannot be terminated mid-cycle for a refund.</li>
                    <li>Free trials (if any) do not involve refunds as no payment is taken.</li>
                    <li>For account or access issues, please contact support.</li>
                </ul>
            </section>

            <section class="contact-footer">
                <h2>Need Help?</h2>
                <p>If you have questions about this policy, please contact our support team:</p>
                <div class="contact-details">
                    <p><strong>Email:</strong> <a href="mailto:contact@keytagjo.com">contact@keytagjo.com</a></p>
                    <p><strong>Response Time:</strong> Within 24 hours</p>
                    <p><strong>Business Hours:</strong> Monday - Friday, 9 AM - 6 PM PST</p>
                </div>
            </section>

        </main>
    </div>
</template>

<script setup>
// Static content, no logic required.
</script>

<style scoped>
.policy-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #333;
    line-height: 1.6;
}

.policy-header {
    text-align: center;
    margin-bottom: 50px;
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.subtitle {
    font-size: 1.2rem;
    font-weight: 600;
    color: #42b983;
    margin: 0;
}

.intro-text {
    font-size: 1.1rem;
    margin-top: 15px;
    color: #555;
    font-weight: 500;
}

.last-updated {
    color: #888;
    font-size: 0.9rem;
    margin-top: 10px;
}

section {
    margin-bottom: 50px;
}

h2 {
    font-size: 1.8rem;
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center; /* Center section headers for this page */
}

/* Steps Section */
.steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.step-card {
    text-align: center;
    padding: 20px;
    background: #fff;
    border: 1px solid #eaeaea;
    border-radius: 8px;
    position: relative;
}

.step-number {
    background: #42b983;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin: 0 auto 15px auto;
}

.step-card h3 {
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.step-card p {
    font-size: 0.9rem;
    color: #666;
}

.note-box {
    background: #fff8e1; /* Light yellow warning */
    color: #8a6d3b;
    padding: 15px;
    border-radius: 6px;
    text-align: center;
    border: 1px solid #faebcc;
}

/* Eligibility Grid */
.section-desc {
    text-align: center;
    color: #666;
    margin-bottom: 30px;
}

.eligibility-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.eligibility-card {
    background: #f9f9f9;
    padding: 25px;
    border-radius: 8px;
    border-left: 4px solid #e74c3c; /* Red border for strict policy */
}

.eligibility-card h3 {
    margin-top: 0;
    font-size: 1.2rem;
    color: #2c3e50;
}

.eligibility-card p {
    color: #555;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.badge {
    display: inline-block;
    background: #ffebeb;
    color: #e74c3c;
    font-size: 0.8rem;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
    text-transform: uppercase;
}

/* Process Section */
.process-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.process-item {
    background: #fff;
    border: 1px solid #eaeaea;
    padding: 20px;
    border-radius: 8px;
}

.process-item h3 {
    font-size: 1.1rem;
    color: #42b983;
    margin-bottom: 5px;
}

.process-item p {
    margin: 0;
    color: #555;
}

/* Notes Section */
.notes-section {
    background: #f4f6f8;
    padding: 30px;
    border-radius: 8px;
}

.notes-list {
    list-style-type: none; /* Custom bullets */
    padding: 0;
}

.notes-list li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 10px;
}

.notes-list li::before {
    content: "•";
    position: absolute;
    left: 0;
    color: #42b983;
    font-weight: bold;
}

/* Contact Footer */
.contact-footer {
    text-align: center;
    border-top: 1px solid #eaeaea;
    padding-top: 40px;
}

.contact-details p {
    margin: 5px 0;
}

.contact-details a {
    color: #42b983;
    text-decoration: none;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .steps-grid {
        grid-template-columns: 1fr;
    }

    .eligibility-grid {
        grid-template-columns: 1fr;
    }
}
</style>
