<button {{ $attributes->merge(['type' => 'submit']) }}
    style="background:linear-gradient(135deg,#1e1b4b,#4f46e5,#7c3aed);color:white;padding:10px 20px;border-radius:8px;font-size:14px;font-weight:600;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(79,70,229,0.35);transition:opacity 0.2s,transform 0.1s;"
    onmouseover="this.style.opacity='0.9';this.style.transform='translateY(-1px)'"
    onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
    {{ $slot }}
</button>