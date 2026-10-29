<!-- DISTINGUISHED SPEAKERS SECTION: Clean Horizontal Editorial Portraits Layout -->
<section class="py-24 px-6 lg:px-12 bg-[#F7F7F4] border-b border-[#101820]/10" id="narasumber">
    <div class="max-w-[1360px] mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-12 border-b border-[#101820]/15">
            <div>
                <span class="text-xs uppercase tracking-widest text-[#E9A443] font-semibold block mb-2">Tokoh &amp; Pembicara Kunci</span>
                <h2 class="font-serif text-3xl sm:text-4xl text-[#101820] font-normal">Narasumber Kehormatan</h2>
            </div>
            <p class="text-xs tracking-wider text-[#5B6471] uppercase font-medium">
                Perwakilan Pemerintah, Pengelola Kawasan &amp; Pimpinan Korporasi
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 pt-12">
            @foreach(config('event.speakers', []) as $index => $speaker)
            <div class="flex flex-col group" id="speaker-card-{{ $index + 1 }}">
                <div class="aspect-[4/5] w-full overflow-hidden bg-[#EFEFEA] mb-6 border border-[#101820]/10">
                    <img 
                        alt="{{ $speaker['name'] }}" 
                        class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" 
                        src="{{ asset($speaker['image']) }}"
                        loading="lazy"
                    />
                </div>
                <span class="text-[11px] uppercase tracking-widest font-semibold text-[#183B5B]">{{ $speaker['role'] }}</span>
                <h3 class="font-serif text-2xl text-[#101820] font-medium mt-1 mb-1.5">{{ $speaker['name'] }}</h3>
                <p class="text-xs text-[#5B6471] leading-relaxed">
                    {{ $speaker['title'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
