function formatAmount(input) {
    input.value = parseFloat(input.value.replace(/,/g, '')).toLocaleString('en-US');
}