// This is your test publishable API key.
const stripe = Stripe("pk_test_51SQk7AB9ISa1F52MCGTp6B7NFwEqbrSYKBJ9iYk748v9k6BbzAcuVwqkRzZWgyAt67YkaXTQbGgGWPmHPd1bfEgh00SfAkuIAZ");

initialize();

// Create a Checkout Session
async function initialize() {
  const fetchClientSecret = async () => {
    const response = await fetch("/checkout.php", {
      method: "POST",
    });
    const { clientSecret } = await response.json();
    return clientSecret;
  };

  const checkout = await stripe.initEmbeddedCheckout({
    fetchClientSecret,
  });

  // Mount Checkout
  checkout.mount('#checkout');
}