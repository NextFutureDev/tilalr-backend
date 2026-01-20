/**
 * Copy Payment Link functionality for Filament Admin Panel
 * Handles copying custom payment offer links to clipboard
 */

function copyPaymentLink(button) {
  const paymentLink = button.getAttribute('data-payment-link');
  
  if (!paymentLink) {
    console.error('No payment link found');
    return;
  }

  // Use modern Clipboard API
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(paymentLink)
      .then(() => {
        showCopySuccess(button);
      })
      .catch((err) => {
        console.error('Failed to copy to clipboard:', err);
        // Fallback to old method
        fallbackCopyToClipboard(paymentLink, button);
      });
  } else {
    // Fallback for older browsers
    fallbackCopyToClipboard(paymentLink, button);
  }
}

function fallbackCopyToClipboard(text, button) {
  const textarea = document.createElement('textarea');
  textarea.value = text;
  textarea.style.position = 'fixed';
  textarea.style.opacity = '0';
  document.body.appendChild(textarea);
  
  try {
    textarea.select();
    document.execCommand('copy');
    showCopySuccess(button);
  } catch (err) {
    console.error('Fallback copy failed:', err);
  } finally {
    document.body.removeChild(textarea);
  }
}

function showCopySuccess(button) {
  // Change button appearance temporarily
  const originalHTML = button.innerHTML;
  const originalBgColor = button.style.backgroundColor;
  
  button.innerHTML = '✓ Copied!';
  button.style.backgroundColor = '#10b981'; // green
  
  setTimeout(() => {
    button.innerHTML = originalHTML;
    button.style.backgroundColor = originalBgColor;
  }, 2000);
}
