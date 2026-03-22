@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
<div class="flex flex-col items-center max-w-5xl mx-auto w-full">
    
    <div class="text-center mb-12">
        <div class="inline-block py-1.5 px-4 rounded-full bg-securx-cyan/10 border border-securx-cyan/20 text-securx-cyan text-xs font-bold tracking-widest uppercase mb-4">
            Partner With Us
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-securx-navy mb-4 tracking-tight">
            Get in Touch
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Whether you are a clinic looking to issue secure prescriptions or a pharmacy joining the network, our team is ready to assist you.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 w-full">
        
        <div class="md:col-span-7">
            <div class="glass-panel p-8">
                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1">Full Name</label>
                        <input type="text" name="name" placeholder="Juan Dela Cruz" class="glass-input w-full py-2.5 px-4">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1">Email Address</label>
                        <input type="email" name="email" placeholder="juan@clinic.com" class="glass-input w-full py-2.5 px-4">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1">Subject</label>
                        <input type="text" name="subject" placeholder="Pharmacy Partnership Inquiry" class="glass-input w-full py-2.5 px-4">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1">Message</label>
                        <textarea name="message" rows="5" placeholder="How can we help you?" class="glass-input w-full py-2.5 px-4"></textarea>
                    </div>

                    <button type="submit" class="glass-btn-primary w-full mt-4 text-lg">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-5 space-y-6">
            
            <div class="glass-panel p-6 flex items-start gap-4 hover:-translate-y-1 transition-transform duration-300">
                <div class="p-3 bg-securx-navy/5 rounded-lg text-securx-navy">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-securx-navy text-lg">Headquarters</h3>
                    <p class="text-sm text-gray-600 mt-1">Angeles University Foundation<br>MacArthur Highway, Angeles City<br>Pampanga, Philippines</p>
                </div>
            </div>

            <div class="glass-panel p-6 flex items-start gap-4 hover:-translate-y-1 transition-transform duration-300">
                <div class="p-3 bg-securx-cyan/10 rounded-lg text-securx-cyan">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-securx-navy text-lg">Email Support</h3>
                    <p class="text-sm text-gray-600 mt-1">partnership@securx.test<br>support@securx.test</p>
                </div>
            </div>

            <div class="glass-panel p-6 flex items-start gap-4 hover:-translate-y-1 transition-transform duration-300">
                <div class="p-3 bg-securx-gold/15 rounded-lg text-securx-gold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-securx-navy text-lg">Direct Line</h3>
                    <p class="text-sm text-gray-600 mt-1">System Admin: (045) 123-4567<br>Mon-Fri, 9:00 AM - 5:00 PM</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection