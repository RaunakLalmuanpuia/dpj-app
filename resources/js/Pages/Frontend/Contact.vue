<template>
    <div class="contact-container">
        <header class="contact-header">
            <h1>Contact Us</h1>
            <p class="subtitle">KeyTagJo</p>
            <p class="intro-text">
                You may contact us using the information below. Our team will be happy to assist you.
            </p>
        </header>

        <main class="contact-grid">
            <section class="info-column">
                <h2>Get in Touch</h2>
                <p class="section-desc">Reach us directly through the following methods:</p>

                <div class="info-card">
                    <div class="icon-wrapper">📧</div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p>Write to us anytime</p>
                        <a href="mailto:contact@keytagjo.com" class="contact-link">contact@keytagjo.com</a>
                        <span class="subtext">We reply within 24 hours</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="icon-wrapper">📍</div>
                    <div class="info-content">
                        <h3>Our Office</h3>
                        <p>Visit us at our registered office location</p>
                        <address>
                            <strong>EIGHTSIS TECH PRIVATE LIMITED</strong><br>
                            2nd Floor, JL Building, Mission Veng,<br>
                            Aizawl, Mizoram 796005
                        </address>
                    </div>
                </div>

                <div class="info-card">
                    <div class="icon-wrapper">🕒</div>
                    <div class="info-content">
                        <h3>Working Hours</h3>
                        <p>Monday - Friday</p>
                        <p class="highlight">9 AM - 6 PM IST</p>
                    </div>
                </div>
            </section>

            <section class="form-column">
                <div class="form-wrapper">
                    <h2>Send us a Message</h2>
                    <p class="form-desc">Fill out the form below and we'll get back to you within 24 hours.</p>

                    <form @submit.prevent="handleSubmit">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input
                                type="text"
                                id="name"
                                v-model="form.name"
                                placeholder="John Doe"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                placeholder="john@example.com"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea
                                id="message"
                                v-model="form.message"
                                rows="5"
                                placeholder="How can we help you?"
                                required
                            ></textarea>
                        </div>

                        <button type="submit" class="submit-btn" :disabled="isSubmitting">
                            {{ isSubmitting ? 'Sending...' : 'Send Message' }}
                        </button>

                        <p v-if="submitStatus" :class="['status-msg', submitStatus.type]">
                            {{ submitStatus.message }}
                        </p>
                    </form>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';

const isSubmitting = ref(false);
const submitStatus = ref(null);

const form = reactive({
    name: '',
    email: '',
    message: ''
});

const handleSubmit = async () => {
    isSubmitting.value = true;
    submitStatus.value = null;

    // Simulate an API call
    setTimeout(() => {
        console.log('Form Submitted:', form);

        // Success State
        submitStatus.value = {
            type: 'success',
            message: 'Thank you! Your message has been sent successfully.'
        };

        // Reset form
        form.name = '';
        form.email = '';
        form.message = '';

        isSubmitting.value = false;
    }, 1500);
};
</script>

<style scoped>
.contact-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #333;
}

.contact-header {
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
    margin-top: 15px;
    color: #666;
}

/* Grid Layout */
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

/* Left Column Styling */
.info-column h2 {
    font-size: 1.8rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.section-desc {
    margin-bottom: 30px;
    color: #666;
}

.info-card {
    display: flex;
    align-items: flex-start;
    margin-bottom: 30px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    transition: transform 0.2s;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.icon-wrapper {
    font-size: 1.5rem;
    margin-right: 15px;
    background: #eef9f5;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.info-content h3 {
    margin: 0 0 5px 0;
    font-size: 1.1rem;
    color: #2c3e50;
}

.info-content p, .info-content address {
    margin: 0 0 5px 0;
    font-style: normal;
    color: #555;
    line-height: 1.5;
}

.contact-link {
    color: #42b983;
    font-weight: 600;
    text-decoration: none;
    display: block;
    margin-bottom: 5px;
}

.subtext {
    font-size: 0.85rem;
    color: #888;
}

.highlight {
    font-weight: 600;
    color: #2c3e50;
}

/* Right Column (Form) Styling */
.form-wrapper {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: 1px solid #eaeaea;
}

.form-wrapper h2 {
    font-size: 1.8rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.form-desc {
    margin-bottom: 25px;
    color: #666;
    font-size: 0.95rem;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2c3e50;
}

input, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s;
    font-family: inherit;
}

input:focus, textarea:focus {
    outline: none;
    border-color: #42b983;
    box-shadow: 0 0 0 3px rgba(66, 185, 131, 0.1);
}

.submit-btn {
    width: 100%;
    padding: 14px;
    background-color: #42b983;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-btn:hover {
    background-color: #3aa876;
}

.submit-btn:disabled {
    background-color: #a0dcc3;
    cursor: not-allowed;
}

.status-msg {
    margin-top: 15px;
    text-align: center;
    font-size: 0.9rem;
    padding: 10px;
    border-radius: 4px;
}

.status-msg.success {
    background-color: #eef9f5;
    color: #2c7a56;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .form-wrapper {
        padding: 20px;
    }
}
</style>
