@extends('layouts.app')
@section('title', 'WeBarber | Contact')

@push('styles')
<style>
  html { scroll-behavior: smooth; }
  body { -webkit-font-smoothing: antialiased; background: #f5f5f7; }

  /* ===== Banner ===== */
  .wb-banner { background: #0a0a0a; padding: 4rem 2rem; text-align: center; }
  .wb-banner .eyebrow { margin: 0 0 1rem; font-size: .7rem; font-weight: 700; letter-spacing: .3em; text-transform: uppercase; color: #b8a060; }
  .wb-banner h2 { margin: 0 0 1rem; font-size: clamp(2rem, 5vw, 3.4rem); font-weight: 800; line-height: 1; letter-spacing: -1px; color: #fff; }
  .wb-banner p.desc { margin: 0 auto; max-width: 500px; font-size: .9rem; font-weight: 300; color: rgba(255,255,255,.6); }

  /* ===== Layout ===== */
  .wb-main { max-width: 960px; margin: 0 auto; padding: 0 1.5rem 6rem; }
  .wb-section { margin-top: 3rem; }
  .wb-section + .wb-section { margin-top: 3.5rem; }
  .wb-section .eyebrow { margin: 0 0 .25rem; font-size: .68rem; font-weight: 700; letter-spacing: .25em; text-transform: uppercase; color: #b8a060; }
  .wb-section h3 { margin: 0 0 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #d2d2d7; font-size: 1.55rem; font-weight: 800; letter-spacing: -.5px; color: #0a0a0a; }

  /* ===== Alerts ===== */
  .wb-alert { display: flex; align-items: flex-start; gap: .75rem; margin-bottom: 1rem; padding: .75rem 1rem; border-radius: .75rem; font-size: .85rem; }
  .wb-alert.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; font-weight: 500; align-items: center; }
  .wb-alert.info { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
  .wb-alert a { font-weight: 600; text-decoration: underline; color: inherit; }

  /* ===== Form ===== */
  .wb-form { background: #fff; border: 1px solid #d2d2d7; border-radius: 1rem; padding: 1.75rem; box-shadow: 0 1px 4px rgba(0,0,0,.04); }
  .wb-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem 1.25rem; }
  .wb-field { display: flex; flex-direction: column; gap: .375rem; min-width: 0; }
  .wb-field.full { margin-top: 1rem; }
  .wb-field label { font-size: .8rem; font-weight: 600; color: #3a3a3c; }
  .wb-field input,
  .wb-field select,
  .wb-field textarea {
    width: 100%; box-sizing: border-box; padding: .75rem .875rem;
    border: 1px solid #d2d2d7; border-radius: .5rem; background: #fff;
    font: inherit; font-size: .88rem; color: #1d1d1f; outline: none;
    transition: border-color .15s, box-shadow .15s;
  }
  .wb-field textarea { resize: vertical; }
  .wb-field input::placeholder,
  .wb-field textarea::placeholder { color: #aeaeb2; }
  .wb-field input:focus,
  .wb-field select:focus,
  .wb-field textarea:focus { border-color: #b8a060; box-shadow: 0 0 0 3px rgba(184,160,96,.2); }

  .wb-actions { display: flex; flex-wrap: wrap; align-items: center; gap: .75rem; margin-top: 1.5rem; }
  .wb-btn {
    display: inline-block; padding: .75rem 1.25rem; border-radius: .5rem;
    font: inherit; font-size: .82rem; font-weight: 600; text-decoration: none;
    cursor: pointer; transition: background .15s;
  }
  .wb-btn.primary { background: #0a0a0a; color: #fff; border: 0; }
  .wb-btn.primary:hover { background: #292929; }
  .wb-btn.ghost { background: #fff; color: #3a3a3c; border: 1px solid #d2d2d7; }
  .wb-btn.ghost:hover { background: #f5f5f7; }
  .wb-btn:focus-visible { outline: 2px solid #b8a060; outline-offset: 2px; }

  /* ===== Table ===== */
  .wb-table-wrap { overflow-x: auto; background: #fff; border: 1px solid #d2d2d7; border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,.05); }
  .wb-table { width: 100%; border-collapse: collapse; text-align: left; font-size: .86rem; }
  .wb-table thead { background: #0a0a0a; }
  .wb-table th { padding: .75rem 1.25rem; font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.7); }
  .wb-table td { padding: 1rem 1.25rem; color: #3a3a3c; border-top: 1px solid #e8e8ed; }
  .wb-table tbody tr:first-child td { border-top: 0; }
  .wb-table tbody tr:hover { background: #f5f5f7; }
  .wb-table td.num { color: #6e6e73; }
  .wb-table td.name { font-weight: 600; color: #0a0a0a; }

  /* ===== About ===== */
  .wb-about { display: flex; flex-direction: column; gap: 1rem; font-size: .9rem; line-height: 1.7; color: #3a3a3c; }
  .wb-about p { margin: 0; }
  .wb-about strong { font-weight: 600; color: #0a0a0a; }

  /* ===== Mobile ===== */
  @media (max-width: 640px) {
    .wb-banner { padding: 3rem 1.25rem; }
    .wb-main { padding: 0 1rem 6rem; }
    .wb-section { margin-top: 2.25rem; }
    .wb-section + .wb-section { margin-top: 2.5rem; }
    .wb-form { padding: 1.25rem; }
    .wb-grid { grid-template-columns: 1fr; }
    .wb-table { min-width: 620px; }
  }
</style>
@endpush

@section('content')

{{-- Banner --}}
<section class="wb-banner">
  <p class="eyebrow">Get in touch</p>
  <h2>Contact Us</h2>
  <p class="desc">Ready to look your best? Fill out the form below to schedule your appointment.</p>
</section>

<main class="wb-main">

  {{-- Reservation Form --}}
  <section class="wb-section" id="reservation">
    <p class="eyebrow">Reservation</p>
    <h3>Reservation Form</h3>

    @if(session('success'))
    <div class="wb-alert success"><span>✓</span> {{ session('success') }}</div>
    @endif

    @auth
    <form action="{{ route('customer.booking.store') }}" method="POST" class="wb-form">
      @csrf
    @else
    <div class="wb-alert info">
      <span>ℹ</span>
      <span><a href="{{ route('login') }}">Login</a> untuk membuat reservasi, atau isi form di bawah sebagai referensi.</span>
    </div>
    <form action="#" method="post" class="wb-form">
    @endauth

      <div class="wb-grid">

        <div class="wb-field">
          <label for="nama">Full Name</label>
          <input type="text" id="nama" name="nama" placeholder="Enter your name" required
            value="{{ auth()->check() ? auth()->user()->name : '' }}" />
        </div>

        <div class="wb-field">
          <label for="telepon">Telephone Number</label>
          <input type="tel" id="telepon" name="telepon" placeholder="08xxxxxxxxxx" required />
        </div>

        <div class="wb-field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Examples@email.com" required
            value="{{ auth()->check() ? auth()->user()->email : '' }}" />
        </div>

        <div class="wb-field" style="grid-column: span 2;">
          <div style="display:flex; align-items:baseline; justify-content:space-between; gap:.5rem; margin-bottom:.5rem;">
            <label style="margin:0;">Choose Service <span style="font-weight:400;color:#aeaeb2;">(can choose more than one)</span></label>
            <span id="svc-summary" style="font-size:.78rem;font-weight:600;color:#111;display:none;">
              <span id="svc-total"></span> · <span id="svc-dur"></span>
            </span>
          </div>
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:.75rem;">
            @foreach($services as $service)
            <label
              class="svc-card"
              data-price="{{ $service->price }}"
              data-duration="{{ $service->duration_minutes }}"
              style="position:relative;display:flex;flex-direction:column;gap:.4rem;padding:1rem 1.1rem;border:1px solid #d2d2d7;border-radius:.875rem;background:#fff;cursor:pointer;transition:all .2s;">
              <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" class="svc-check" style="position:absolute;opacity:0;pointer-events:none;" />
              {{-- tick --}}
              <span class="svc-tick" style="position:absolute;top:.65rem;right:.75rem;width:1.1rem;height:1.1rem;border-radius:50%;border:1px solid #d2d2d7;display:flex;align-items:center;justify-content:center;font-size:.6rem;font-weight:700;transition:all .2s;"></span>
              {{-- nama & harga --}}
              <div style="display:flex;align-items:baseline;justify-content:space-between;gap:.5rem;padding-right:1.5rem;">
                <span class="svc-name" style="font-size:.88rem;font-weight:700;color:#0a0a0a;line-height:1.3;transition:color .2s;">{{ $service->name }}</span>
                <span class="svc-price" style="font-size:.82rem;font-weight:700;white-space:nowrap;color:#0a0a0a;transition:color .2s;">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
              </div>
              {{-- durasi & hint --}}
              <div style="display:flex;align-items:center;justify-content:space-between;margin-top:.15rem;">
                <span class="svc-dur-label" style="font-size:.68rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#aeaeb2;transition:color .2s;">± {{ $service->duration_minutes }} min</span>
                <span class="svc-hint" style="font-size:.68rem;font-weight:700;letter-spacing:.04em;color:transparent;transition:color .2s;">PILIH →</span>
              </div>
            </label>
            @endforeach
          </div>
          @error('service_ids')
          <p style="font-size:.78rem;color:#dc2626;margin-top:.25rem;">⚠ Pilih minimal satu layanan.</p>
          @enderror
        </div>

        <div class="wb-field">
          <label for="barber">Choose Barber</label>
          <select id="barber" name="barber_id" required>
            <option value="" selected disabled>Choose barber</option>
            @foreach($barbers as $barber)
            <option value="{{ $barber->id }}">{{ $barber->user->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="wb-field">
          <label for="date">Reservation Date</label>
          <input type="date" id="date" name="booking_date" required min="{{ date('Y-m-d') }}" />
        </div>

        <div class="wb-field">
          <label for="time">Time Reservation</label>
          <input type="time" id="time" name="start_time" min="09:00" max="21:00" required />
        </div>

      </div>

      <div class="wb-field full">
        <label for="Note">Note for the Barber</label>
        <textarea id="Note" name="notes" rows="4" placeholder="Example: What hairstyle do you want?..."></textarea>
      </div>

      <div class="wb-actions">
        @auth
        <button type="submit" class="wb-btn primary">Make a reservation</button>
        <button type="reset" class="wb-btn ghost">Reset</button>
        @else
        <a href="{{ route('login') }}" class="wb-btn primary">Login to Book →</a>
        @endauth
      </div>

    </form>
  </section>

  {{-- Owner & Founder --}}
  <section class="wb-section">
    <p class="eyebrow">The people behind WeBarber</p>
    <h3>Owner &amp; Founder</h3>
    <div class="wb-table-wrap">
      <table class="wb-table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Name</th>
            <th scope="col">Position</th>
            <th scope="col">Contact</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="num">1</td>
            <td class="name">Evan</td>
            <td>Founder &amp; Head Barber</td>
            <td>evangalangwry11@email.com</td>
          </tr>
          <tr>
            <td class="num">2</td>
            <td class="name">Fairus</td>
            <td>Co-Founder &amp; Operations Manager</td>
            <td>fairuzrasidin33@email.com</td>
          </tr>
          <tr>
            <td class="num">3</td>
            <td class="name">Ahmad</td>
            <td>Barber</td>
            <td>ahmadmohamed44@email.com</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  {{-- About Us --}}
  <section class="wb-section">
    <p class="eyebrow">Our story</p>
    <h3>About Us</h3>
    <div class="wb-about">
      <p>WeBarber is the ultimate destination to reclaim your confidence when other barbers have missed the mark. We deliver a top-tier grooming experience that is precise, comfortable, and built on a foundation of trust with every client.</p>
      <p>Backed by experienced barbers, strictly hygienic tools, and personalized style consultations before every cut, we help you achieve a flawless look tailored to your unique character and lifestyle.</p>
      <p>Whether you want a classic look or modern looking, we offer a full range of premium grooming services all provided in a relaxed yet professional environment.</p>
    </div>
  </section>

</main>
@push('scripts')
<script>
  const cards      = document.querySelectorAll('.svc-card');
  const summaryEl  = document.getElementById('svc-summary');
  const totalEl    = document.getElementById('svc-total');
  const durEl      = document.getElementById('svc-dur');

  function formatRp(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
  }

  function updateSummary() {
    let total = 0, mins = 0, count = 0;
    cards.forEach(card => {
      if (card.querySelector('.svc-check').checked) {
        total += parseFloat(card.dataset.price);
        mins  += parseInt(card.dataset.duration);
        count++;
      }
    });
    if (count > 0) {
      totalEl.textContent = formatRp(total);
      durEl.textContent   = '± ' + mins + ' min';
      summaryEl.style.display = 'inline';
    } else {
      summaryEl.style.display = 'none';
    }
  }

  function applyStyle(card, checked) {
    const tick     = card.querySelector('.svc-tick');
    const nameEl   = card.querySelector('.svc-name');
    const priceEl  = card.querySelector('.svc-price');
    const durLabel = card.querySelector('.svc-dur-label');
    const hintEl   = card.querySelector('.svc-hint');

    if (checked) {
      card.style.background   = '#0a0a0a';
      card.style.borderColor  = '#0a0a0a';
      card.style.boxShadow    = '0 4px 16px rgba(0,0,0,.18)';
      card.style.transform    = 'translateY(-2px)';
      tick.style.background   = '#b8a060';
      tick.style.borderColor  = '#b8a060';
      tick.style.color        = '#fff';
      tick.textContent        = '✓';
      nameEl.style.color      = '#fff';
      priceEl.style.color     = '#b8a060';
      durLabel.style.color    = 'rgba(255,255,255,.4)';
      hintEl.style.color      = '#b8a060';
      hintEl.textContent      = 'DIPILIH ✓';
    } else {
      card.style.background   = '#fff';
      card.style.borderColor  = '#d2d2d7';
      card.style.boxShadow    = '';
      card.style.transform    = '';
      tick.style.background   = '';
      tick.style.borderColor  = '#d2d2d7';
      tick.style.color        = 'transparent';
      tick.textContent        = '✓';
      nameEl.style.color      = '#0a0a0a';
      priceEl.style.color     = '#0a0a0a';
      durLabel.style.color    = '#aeaeb2';
      hintEl.style.color      = 'transparent';
      hintEl.textContent      = 'PILIH →';
    }
  }

  cards.forEach(card => {
    const cb = card.querySelector('.svc-check');

    // Hover effect
    card.addEventListener('mouseenter', () => {
      if (!cb.checked) card.style.borderColor = '#0a0a0a';
    });
    card.addEventListener('mouseleave', () => {
      if (!cb.checked) { card.style.borderColor = '#d2d2d7'; card.querySelector('.svc-hint').style.color = 'transparent'; }
    });
    card.addEventListener('mouseenter', () => {
      if (!cb.checked) card.querySelector('.svc-hint').style.color = '#6e6e73';
    });

    card.addEventListener('click', () => {
      cb.checked = !cb.checked;
      applyStyle(card, cb.checked);
      updateSummary();
    });

    applyStyle(card, cb.checked);
  });

  updateSummary();
</script>
@endpush

@endsection