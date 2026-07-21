// Client-side KPR (mortgage) simulator — mirrors the design's live calculator.
// This is a convenience preview only; it does not persist or validate anything
// server-side, since it has no side effects worth protecting.
function formatRupiah(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function calculate() {
    const priceEl = document.getElementById('kpr-price');
    const dpEl = document.getElementById('kpr-dp');
    const yearsEl = document.getElementById('kpr-years');
    const rateEl = document.getElementById('kpr-rate');
    if (!priceEl || !dpEl || !yearsEl || !rateEl) return;

    const price = Math.max(0, Number(priceEl.value) || 0);
    let dp = Math.max(0, Number(dpEl.value) || 0);
    dp = Math.min(dp, price);
    const years = Math.min(30, Math.max(1, Number(yearsEl.value) || 1));
    const rate = Math.max(0, Number(rateEl.value) || 0);

    const loan = Math.max(price - dp, 0);
    const monthlyRate = rate / 100 / 12;
    const n = years * 12;
    const monthly = monthlyRate > 0 && n > 0
        ? (loan * monthlyRate * Math.pow(1 + monthlyRate, n)) / (Math.pow(1 + monthlyRate, n) - 1)
        : (n > 0 ? loan / n : 0);
    const dpPercent = price > 0 ? Math.round((dp / price) * 100) : 0;

    document.getElementById('kpr-dp-percent').textContent = dpPercent + '%';
    document.getElementById('kpr-loan-amount').textContent = formatRupiah(loan);
    document.getElementById('kpr-monthly').textContent = formatRupiah(monthly || 0);
}

document.addEventListener('DOMContentLoaded', () => {
    ['kpr-price', 'kpr-dp', 'kpr-years', 'kpr-rate'].forEach((id) => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', calculate);
    });
    calculate();
});
