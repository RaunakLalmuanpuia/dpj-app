<template>
    <div class="min-h-screen bg-[#FDFCFB] text-slate-900 selection:bg-orange-100 overflow-x-hidden">

        <nav class="sticky top-0 z-50 bg-[#FDFCFB]/80 backdrop-blur-md border-b border-slate-100">
            <div class="flex items-center justify-between px-6 md:px-12 py-5 max-w-7xl mx-auto">
                <div class="text-3xl font-serif font-black tracking-tighter text-indigo-950">DPJ<span class="text-orange-500">.</span></div>
                <div class="items-center space-x-10 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">
                    <a href="#process" class="hover:text-orange-500 transition">The Flow</a>
                    <a href="#pricing" class="hover:text-orange-500 transition">Artisan Plans</a>
                    <a href="#testimonials" class="hover:text-orange-500 transition">Reviews</a>
                </div>
                <button class="bg-indigo-950 text-white px-7 py-2.5 rounded-full text-sm font-bold hover:bg-orange-600 transition shadow-lg shadow-indigo-100">
                    Member Login
                </button>
            </div>
        </nav>

        <header class="relative px-6 pt-16 md:pt-28 pb-20 text-center max-w-5xl mx-auto">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[500px] bg-gradient-to-b from-orange-50/50 to-transparent rounded-full blur-3xl -z-10"></div>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 border border-orange-100 text-orange-700 text-xs font-bold mb-8 animate-fade-in">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
                ARTISAN SHEETS NOW SYNCING WITH GOOGLE DRIVE
            </div>

            <h1 class="text-5xl md:text-8xl font-serif font-medium leading-[1.05] mb-8 text-indigo-950 tracking-tight">
                Curated journals, <br/>
                <span class="italic font-light text-slate-400">customized for you.</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-2xl mx-auto leading-relaxed">
                Experience the world's most sophisticated journaling system. DPJ delivers <strong>bespoke, ready-to-write sheets</strong> designed by productivity experts directly to your Google Drive.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="#pricing" class="w-full sm:w-auto px-10 py-5 bg-indigo-950 text-white rounded-full text-lg font-bold hover:scale-105 transition-transform shadow-2xl">
                    Claim Your Custom Sheets
                </a>
                <div class="flex -space-x-3 overflow-hidden">
                    <img class="inline-block h-10 w-10 rounded-full ring-2 ring-[#FDFCFB]" src="https://i.pravatar.cc/100?u=1" alt="">
                    <img class="inline-block h-10 w-10 rounded-full ring-2 ring-[#FDFCFB]" src="https://i.pravatar.cc/100?u=2" alt="">
                    <img class="inline-block h-10 w-10 rounded-full ring-2 ring-[#FDFCFB]" src="https://i.pravatar.cc/100?u=3" alt="">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-100 text-[10px] font-bold text-orange-600 ring-2 ring-[#FDFCFB]">1k+</div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-6 py-10 border-y border-slate-100 flex flex-wrap justify-center gap-8 md:gap-20 opacity-50 grayscale">
            <span class="font-serif font-bold text-xl tracking-tight text-indigo-950">Tailored Design</span>
            <span class="font-serif font-bold text-xl tracking-tight text-indigo-950">Automated Delivery</span>
            <span class="font-serif font-bold text-xl tracking-tight text-indigo-950">Secure Sync</span>
        </div>

        <section id="pricing" class="max-w-7xl mx-auto px-6 py-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-serif text-indigo-950 mb-4">Select your level of clarity</h2>
                <p class="text-slate-500 italic max-w-xl mx-auto">Every plan includes our signature artisan layouts. Focus and Legacy plans feature <strong>full customization</strong> based on your goals.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="(plan, index) in plans" :key="index"
                     class="relative group p-8 rounded-[2.5rem] bg-white border border-slate-100 transition-all duration-500 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 overflow-hidden"
                     :class="{'ring-2 ring-orange-500 shadow-xl': plan.popular}">

                    <div v-if="plan.popular" class="absolute top-0 left-0 right-0 bg-orange-500 py-1.5 text-center text-[10px] text-white font-black uppercase tracking-widest">
                        Best Seller
                    </div>

                    <div class="mb-8">
                        <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-4">{{ plan.title }}</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-serif font-bold text-indigo-950">${{ plan.price }}</span>
                            <span class="text-slate-400 text-sm italic">/{{ plan.period }}</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 min-h-[160px]">
                        <li v-for="feat in plan.features" :key="feat" class="text-sm text-slate-600 flex items-start gap-3">
                            <svg class="w-4 h-4 text-orange-500 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ feat }}</span>
                        </li>
                    </ul>

                    <button class="w-full py-4 rounded-2xl font-bold text-sm transition-all duration-300"
                            :class="plan.popular ? 'bg-orange-500 text-white hover:bg-orange-600 shadow-lg shadow-orange-100' : 'bg-slate-50 text-indigo-950 hover:bg-indigo-950 hover:text-white'">
                        Connect Gmail & Start
                    </button>
                </div>
            </div>
        </section>

        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <span class="text-orange-500 font-bold tracking-widest text-xs uppercase">The DPJ Standard</span>
                <h2 class="text-4xl font-serif text-indigo-950 mt-4 mb-8 italic">"Not just a template, but a transformation."</h2>
                <p class="text-slate-600 leading-relaxed text-lg">
                    Every DPJ sheet is crafted with white-space theory and psychological prompts to help you dig deeper. For our premium users, we adjust the grid, the prompts, and the goals to align perfectly with your personal or professional journey.
                </p>
            </div>
        </section>

        <section id="testimonials" class="bg-indigo-950 py-24 text-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-center text-3xl md:text-5xl font-serif mb-16">Stories from the mindful.</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="t in testimonials" :key="t.name" class="p-8 rounded-3xl bg-white/5 border border-white/10 hover:bg-white/10 transition">
                        <div class="flex gap-1 text-orange-400 mb-4 text-xs">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <p class="text-indigo-100 italic mb-8 leading-relaxed">"{{ t.quote }}"</p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-orange-200 overflow-hidden">
                                <img :src="`https://i.pravatar.cc/100?u=${t.name}`" alt="">
                            </div>
                            <div>
                                <div class="text-sm font-bold">{{ t.name }}</div>
                                <div class="text-[10px] text-indigo-400 uppercase tracking-widest">{{ t.role }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-5xl mx-auto px-6 py-32 text-center">
            <div class="text-6xl mb-8">✨</div>
            <h2 class="text-4xl font-serif text-indigo-950 mb-6">Experience customized journaling.</h2>
            <p class="text-slate-500 mb-10">Sign in with Gmail to sync your artisanal sheets today.</p>
            <button class="px-12 py-5 bg-orange-500 text-white rounded-full font-black hover:scale-105 transition shadow-2xl shadow-orange-200 uppercase tracking-widest text-sm">
                Connect Gmail & Pay
            </button>
        </section>

        <footer class="bg-white py-24 px-6 border-t border-slate-100">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-16">

                    <div class="md:col-span-5 lg:col-span-6 space-y-6">
                        <div class="text-3xl font-serif font-black text-indigo-950 tracking-tighter">
                            DPJ<span class="text-orange-500">.</span>
                        </div>
                        <p class="text-slate-500 max-w-sm text-base leading-relaxed">
                            The intersection of artisan design and digital automation. We craft bespoke journaling experiences delivered directly to your Google Drive.
                        </p>
                        <div class="flex items-center gap-2 pt-2">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">All Systems Operational</span>
                        </div>
                    </div>

                    <div class="md:col-span-3 lg:col-span-2">
                        <h4 class="font-bold text-[11px] uppercase tracking-[0.2em] text-indigo-950 mb-8">Product</h4>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Artisan Gallery</a></li>
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Customization</a></li>
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Drive Security</a></li>
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Pricing Plans</a></li>
                        </ul>
                    </div>

                    <div class="md:col-span-2 lg:col-span-2">
                        <h4 class="font-bold text-[11px] uppercase tracking-[0.2em] text-indigo-950 mb-8">Support</h4>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Gmail Setup</a></li>
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Help Center</a></li>
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Privacy Policy</a></li>
                            <li><a href="#" class="text-slate-500 hover:text-orange-600 transition-colors text-sm">Terms of Service</a></li>
                        </ul>
                    </div>

                    <div class="md:col-span-2 lg:col-span-2">
                        <h4 class="font-bold text-[11px] uppercase tracking-[0.2em] text-indigo-950 mb-8">Connect</h4>
                        <div class="flex flex-col space-y-4">
                            <a href="mailto:hello@dpj.com" class="text-slate-500 hover:text-orange-600 transition-colors text-sm break-all">hello@dpj.com</a>
                            <div class="flex gap-4 pt-2">
                                <a href="#" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center hover:bg-orange-50 hover:text-orange-600 transition-all">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                                </a>
                                <a href="#" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center hover:bg-orange-50 hover:text-orange-600 transition-all">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-slate-400 text-[11px] font-medium tracking-wide">
                        &copy; 2025 DIGITAL PERSONAL JOURNAL. ALL RIGHTS RESERVED.
                    </div>
                    <div class="flex items-center gap-6">
                        <span class="text-[10px] text-slate-300 font-bold tracking-widest uppercase italic">Built for Clarity</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
const plans = [
    { title: 'Essential', price: '12', period: 'mo', features: ['Monthly Artisan Sheets', 'Standard Goal Layouts', 'Instant Drive Sync'], popular: false },
    { title: 'Habit', price: '29', period: '3 mo', features: ['Quarterly Artisan Set', 'Progress Tracking Sheets', 'Habit-Focused Layouts', 'Priority Drive Sync'], popular: false },
    { title: 'Focus', price: '49', period: '6 mo', features: ['Fully Customized Prompts', 'Artisan Goal-Mapping', 'Personalized Page Grids', 'Deep Work Templates'], popular: true },
    { title: 'Legacy', price: '89', period: 'yr', features: ['Bespoke Yearly Strategy', 'Personal Branding on Sheets', 'Executive Goal Layouts', 'Concierge Customization'], popular: false },
]

const testimonials = [
    { name: 'Sarah Jenkins', role: 'Creative Lead', quote: 'The bespoke prompts in the Focus plan feel like they were written exactly for my career path.' },
    { name: 'Marcus Chen', role: 'Founder', quote: 'I’ve tried every journal app. Nothing compares to the quality of these customized DPJ sheets.' },
    { name: 'Elena Rossi', role: 'Author', quote: 'Beautifully automated and artistically designed. It is the gold standard for digital journaling.' },
]
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    scroll-behavior: smooth;
}

.font-serif {
    font-family: 'Playfair Display', serif;
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 1s ease-out;
}
</style>
