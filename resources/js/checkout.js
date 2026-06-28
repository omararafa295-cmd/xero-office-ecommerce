document.addEventListener('DOMContentLoaded', function () {
    const checkoutMessages = window.checkoutMessages || {};
    const governorateSelect = document.getElementById('governorateSelect');
    const shippingCostDisplay = document.getElementById('shippingCostDisplay');
    const totalAmountDisplay = document.getElementById('totalAmountDisplay');
    const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');
    const walletNumberWrapper = document.getElementById('walletNumberWrapper');
    const walletNumberInput = document.getElementById('walletNumberInput');
    const paymentMethodHint = document.getElementById('paymentMethodHint');
    const cardPreviewSection = document.getElementById('cardPreviewSection');
    const cardPreviewInner = document.getElementById('cardPreviewInner');
    const cardUiNumber = document.getElementById('cardUiNumber');
    const cardUiName = document.getElementById('cardUiName');
    const cardUiExpiry = document.getElementById('cardUiExpiry');
    const cardUiCvv = document.getElementById('cardUiCvv');
    const cardPreviewNumber = document.getElementById('cardPreviewNumber');
    const cardPreviewName = document.getElementById('cardPreviewName');
    const cardPreviewExpiry = document.getElementById('cardPreviewExpiry');
    const cardPreviewCvv = document.getElementById('cardPreviewCvv');

    if (!governorateSelect || !shippingCostDisplay || !totalAmountDisplay || !paymentMethodHint) {
        return;
    }

    const subtotal = parseFloat(totalAmountDisplay.getAttribute('data-subtotal')) || 0;
    const discount = parseFloat(totalAmountDisplay.getAttribute('data-discount')) || 0;

    const formatCardNumber = (value) => value.replace(/\D/g, '').slice(0, 16).replace(/(.{4})/g, '$1 ').trim();
    const formatExpiry = (value) => {
        const clean = value.replace(/\D/g, '').slice(0, 4);
        if (clean.length < 3) return clean;
        return `${clean.slice(0, 2)}/${clean.slice(2)}`;
    };

    const updateShippingSummary = () => {
        const selectedOption = governorateSelect.options[governorateSelect.selectedIndex];
        const shippingCost = parseFloat(selectedOption?.getAttribute('data-cost') || 0);

        if (shippingCost > 0) {
            shippingCostDisplay.innerHTML = `<span class="text-red-600 font-black">${shippingCost.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span> ${checkoutMessages.currency || 'ج.م'}`;
            const newTotal = Math.max(0, subtotal - discount) + shippingCost;
            totalAmountDisplay.innerHTML = `${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} ${checkoutMessages.currency || 'ج.م'}`;
            return;
        }

        shippingCostDisplay.innerHTML = checkoutMessages.shippingDefault || 'يحدد حسب المحافظة';
        const newTotal = Math.max(0, subtotal - discount);
        totalAmountDisplay.innerHTML = `${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} ${checkoutMessages.currency || 'ج.م'}`;
    };

    const updateCardPreview = () => {
        if (!cardUiNumber || !cardUiName || !cardUiExpiry || !cardUiCvv || !cardPreviewNumber || !cardPreviewName || !cardPreviewExpiry || !cardPreviewCvv) {
            return;
        }

        cardUiNumber.value = formatCardNumber(cardUiNumber.value);
        cardUiExpiry.value = formatExpiry(cardUiExpiry.value);
        cardUiCvv.value = cardUiCvv.value.replace(/\D/g, '').slice(0, 4);

        cardPreviewNumber.textContent = cardUiNumber.value || '•••• •••• •••• ••••';
        cardPreviewName.textContent = (cardUiName.value || 'YOUR NAME').toUpperCase();
        cardPreviewExpiry.textContent = cardUiExpiry.value || 'MM/YY';
        cardPreviewCvv.textContent = cardUiCvv.value || '•••';
    };

    const updatePaymentMethodUI = () => {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked')?.value || 'cash';
        const isWallet = selectedMethod === 'wallet';
        const isCard = selectedMethod === 'card';

        walletNumberWrapper?.classList.toggle('hidden', !isWallet);
        cardPreviewSection?.classList.toggle('hidden', !isCard);

        if (walletNumberInput) {
            walletNumberInput.required = isWallet;
        }

        if (selectedMethod === 'cash') {
            paymentMethodHint.innerHTML = `<span class="text-base">•</span> ${checkoutMessages.cash || 'سيتم سداد قيمة الطلب عند الاستلام.'}`;
            return;
        }

        if (selectedMethod === 'card') {
            paymentMethodHint.innerHTML = `<span class="text-base">•</span> ${checkoutMessages.card || 'سيتم استكمال الدفع الإلكتروني بشكل آمن بعد تأكيد الطلب.'}`;
            return;
        }

        paymentMethodHint.innerHTML = `<span class="text-base">•</span> ${checkoutMessages.wallet || 'سيتم إرسال طلب الدفع إلى محفظتك بعد تأكيد الطلب.'}`;
    };

    cardUiCvv?.addEventListener('focus', () => {
        if (cardPreviewInner) {
            cardPreviewInner.style.transform = 'rotateY(180deg)';
        }
    });

    cardUiCvv?.addEventListener('blur', () => {
        if (cardPreviewInner) {
            cardPreviewInner.style.transform = 'rotateY(0deg)';
        }
    });

    [cardUiNumber, cardUiName, cardUiExpiry, cardUiCvv].forEach((input) => input?.addEventListener('input', updateCardPreview));
    paymentMethodInputs.forEach((input) => input.addEventListener('change', updatePaymentMethodUI));

    governorateSelect.addEventListener('change', updateShippingSummary);
    updateShippingSummary();
    updatePaymentMethodUI();
    updateCardPreview();
});
