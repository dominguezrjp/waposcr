<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
  function makePayment() {
    FlutterwaveCheckout({
      public_key: `<?= $public_key;?>`,
      tx_ref: `<?= $rand_id;?>`,
      amount: `<?= $amount;?>`,
      currency: `<?= $currency;?>`,
      payment_options: "card, banktransfer, ussd",
      redirect_url: `<?= $redirect_url;?>`,
      meta: {
        consumer_id: '',
        consumer_mac: "",
      },
      customer: {
        email: `<?= $email??'empty';?>`,
        phone_number: <?= $phone??0;?>,
        name: `<?= $slug;?>`,
        slug: `<?= $slug;?>`,
        account_slug: `<?= $account_slug;?>`,
      },
      customizations: {
        title: `<?= $title;?>`,
        description: "Payment for an awesome cruise",
        logo: `<?= base_url($settings['logo']??'');?>`,
      },
    });
  }
</script>