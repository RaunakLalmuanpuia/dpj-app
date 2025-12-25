<template>
    <div class="min-h-screen bg-[#FDFCFB] text-slate-900 selection:bg-orange-100 overflow-x-hidden">

        <nav class="sticky top-0 z-50 bg-[#FDFCFB]/80 backdrop-blur-md border-b border-slate-100">
            <div class="flex items-center justify-between px-6 md:px-12 py-5 max-w-7xl mx-auto">
                <div class="text-3xl font-serif font-black tracking-tighter text-indigo-950">DPJ<span class="text-orange-500">.</span></div>
                <div class="items-center space-x-10 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">
                    <a href="#collections" class="hover:text-orange-500 transition">Collections</a>
                    <a href="#about" class="hover:text-orange-500 transition">Philosophy</a>
                    <a href="#testimonials" class="hover:text-orange-500 transition">Community</a>
                </div>
                <button class="bg-indigo-950 text-white px-7 py-2.5 rounded-full text-sm font-bold hover:bg-orange-600 transition shadow-lg shadow-indigo-100">
                    Free Access
                </button>
            </div>
        </nav>

        <header class="relative px-6 pt-16 md:pt-28 pb-20 flex flex-col items-center text-center max-w-5xl mx-auto">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[500px] bg-gradient-to-b from-orange-50/50 to-transparent rounded-full blur-3xl -z-10"></div>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 border border-orange-100 text-orange-700 text-xs font-bold mb-8 animate-fade-in">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
                OPEN SOURCE & FREE FOREVER
            </div>

            <h1 class="text-5xl md:text-8xl font-serif font-medium leading-[1.05] mb-8 text-indigo-950 tracking-tight">
                Premium journals, <br/>
                <span class="italic font-light text-slate-400">designed for clarity.</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-2xl mx-auto leading-relaxed text-center">
                Experience the world's most sophisticated journaling layouts. Pick a collection below and sync <strong>artisan, ready-to-write sheets</strong> directly to your Google Drive.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="#collections" class="w-full sm:w-auto px-10 py-5 bg-indigo-950 text-white rounded-full text-lg font-bold hover:scale-105 transition-transform shadow-2xl">
                    Choose Your Collection
                </a>
            </div>
        </header>

        <section id="collections" class="max-w-7xl mx-auto px-6 py-24">
            <div class="flex flex-col items-center text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-serif text-indigo-950 mb-4 text-center">Professional systems for everyone.</h2>
                <p class="text-slate-500 italic max-w-xl mx-auto text-center leading-relaxed">
                    Select the workflow that matches your goals. Every collection is fully automated and free.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="(plan, index) in plans" :key="index"
                     class="relative group p-8 rounded-[2.5rem] bg-white border border-slate-100 transition-all duration-500 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 overflow-hidden">

                    <div class="mb-8">
                        <div class="text-orange-500 font-black text-[10px] uppercase tracking-widest mb-2">Collection 0{{index + 1}}</div>
                        <h3 class="text-2xl font-serif font-bold text-indigo-950 mb-4">{{ plan.title }}</h3>
                        <div class="text-emerald-500 text-xs font-bold">✓ Lifetime Access</div>
                    </div>

                    <ul class="space-y-4 mb-10 min-h-[160px]">
                        <li v-for="feat in plan.features" :key="feat" class="text-sm text-slate-600 flex items-start gap-3">
                            <svg class="w-4 h-4 text-orange-500 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ feat }}</span>
                        </li>
                    </ul>

                    <a
                        :href="route('google.redirect',{ plan: plan.title.toLowerCase() })"
                        class="block w-full py-4 rounded-2xl font-bold text-sm bg-slate-50 text-indigo-950
                        hover:bg-indigo-950 hover:text-white transition-all duration-300 text-center"
                    >
                        Sync to Drive
                    </a>
                </div>
            </div>
        </section>

        <section id="about" class="py-24 bg-indigo-950 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-white/5 skew-x-12 translate-x-32"></div>
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="grid md:grid-cols-2 gap-16 items-center">
                    <div>
                        <span class="text-orange-500 font-bold tracking-widest text-xs uppercase block mb-4">Our Philosophy</span>
                        <h2 class="text-4xl md:text-6xl font-serif leading-tight mb-8">Journaling is the <span class="italic text-slate-400">interface</span> for your mind.</h2>
                        <div class="space-y-6 text-indigo-100/80 text-lg leading-relaxed">
                            <p>We believe that productivity isn't about doing more, but about thinking more clearly. Our layouts use <strong>white-space theory</strong> and cognitive prompts to bypass the "blank page" anxiety.</p>
                            <p>By automating the delivery to Google Drive, we remove the friction of setup. You focus on the writing; we focus on the structure.</p>
                        </div>
                        <div class="mt-10 flex gap-8">
                            <div>
                                <div class="text-3xl font-serif text-orange-500 mb-1">100%</div>
                                <div class="text-[10px] uppercase tracking-widest font-bold">Privacy Owned</div>
                            </div>
                            <div>
                                <div class="text-3xl font-serif text-orange-500 mb-1">Zero</div>
                                <div class="text-[10px] uppercase tracking-widest font-bold">Subscription Fees</div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="aspect-square rounded-3xl bg-gradient-to-br from-indigo-800 to-indigo-900 border border-white/10 p-8 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-6xl mb-4">✍️</div>
                                <div class="text-sm font-serif italic text-slate-300">"The palest ink is better than the best memory."</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials" class="max-w-7xl mx-auto px-6 py-24">
            <div class="flex flex-col items-center text-center mb-16">
                <span class="text-orange-500 font-bold tracking-widest text-xs uppercase block mb-4">Community Voices</span>
                <h2 class="text-4xl md:text-5xl font-serif text-indigo-950 mb-4">Trusted by 5,000+ writers.</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div v-for="t in testimonials" :key="t.name" class="p-10 rounded-[2rem] bg-white border border-slate-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex gap-1 text-orange-400 mb-6">
                        <span v-for="i in 5" :key="i">★</span>
                    </div>
                    <p class="text-slate-600 italic text-lg leading-relaxed mb-8">"{{ t.quote }}"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden">
                            <img :src="`https://i.pravatar.cc/100?u=${t.name}`" :alt="t.name">
                        </div>
                        <div>
                            <div class="text-sm font-black text-indigo-950">{{ t.name }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">{{ t.role }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-white border-t border-slate-100 pt-24 pb-12 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-20">

                    <div class="col-span-2 lg:col-span-2">
                        <div class="text-3xl font-serif font-black tracking-tighter text-indigo-950 mb-6">DPJ<span class="text-orange-500">.</span></div>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-xs mb-8">
                            A curated library of digital journaling tools designed to help you think clearly, act intentionally, and live purposefully.
                        </p>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-orange-50 hover:text-orange-500 cursor-pointer transition text-xs font-bold">TW</div>
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-orange-50 hover:text-orange-500 cursor-pointer transition text-xs font-bold">IG</div>
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-orange-50 hover:text-orange-500 cursor-pointer transition text-xs font-bold">YT</div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-[11px] font-bold uppercase tracking-widest text-indigo-950 mb-6">Collections</h4>
                        <ul class="space-y-4 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-orange-500 transition">Daily Essential</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Habit Tracker</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Deep Work</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Legacy Yearly</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-[11px] font-bold uppercase tracking-widest text-indigo-950 mb-6">Explore</h4>
                        <ul class="space-y-4 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-orange-500 transition">Philosophy</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Google Drive Setup</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Automation FAQ</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Prompts Guide</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-[11px] font-bold uppercase tracking-widest text-indigo-950 mb-6">Company</h4>
                        <ul class="space-y-4 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-orange-500 transition">About Us</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Terms of Use</a></li>
                            <li><a href="#" class="hover:text-orange-500 transition">Support</a></li>
                        </ul>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-slate-50 gap-4">
                    <p class="text-slate-400 text-[10px] font-bold tracking-[0.2em] uppercase">
                        © 2025 DIGITAL PERSONAL JOURNAL. ALL RIGHTS RESERVED.
                    </p>
                    <div class="flex items-center gap-6">
                        <span class="text-[10px] text-slate-300 font-bold italic">Built for Clarity</span>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">System Status: Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { usePage} from "@inertiajs/vue3";


const page = usePage()

onMounted(() => {
    const url = page.props.flash?.drive_url
    if (url) {
        window.open(url, '_blank')
    }
})
const plans = [
    { title: 'Essential', features: ['Monthly Artisan Sheets', 'Standard Goal Layouts', 'Morning Prompts', 'Instant Drive Sync'] },
    { title: 'Habit', features: ['Quarterly Artisan Set', 'Progress Tracking', 'Habit-Focused Layouts', 'Priority Drive Sync'] },
    { title: 'Focus', features: ['Deep Work Prompts', 'Artisan Goal-Mapping', 'Personalized Grids', 'Daily Focus Templates'] },
    { title: 'Legacy', features: ['Yearly Strategy', 'Executive Layouts', 'Legacy Archive Prompts', 'Full Drive Automation'] },
]

const testimonials = [
    { name: 'Sarah Jenkins', role: 'Creative Lead', quote: 'I used to pay for these layouts. The fact that they are now free is a gift to the community.' },
    { name: 'Marcus Chen', role: 'Founder', quote: 'The Legacy collection is how I run my entire quarterly planning now.' },
    { name: 'Elena Rossi', role: 'Author', quote: 'Artistic, clean, and perfectly integrated with Google Drive. Simply the best.' },
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
