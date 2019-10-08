<template>
  <div class="wrapper fadeInDown mt-5">
    <div class="bg-dark" id="formContent">
      <!-- Tabs Titles -->

      <!-- Icon -->
      <div class="fadeIn first bg-dark mt-4 mb-2"></div>

      <!-- Login Form -->
      <form ref="form" @submit.prevent="getFormValues()" class="bg-dark">
        <input
          type="text"
          id="email"
          v-model="email"
          class="fadeIn second bg-dark"
          name="emaila"
          placeholder="Email za uclanjenje"
        />

        <div v-if="subexist" id="postojiemail" class="bg-info mb-2 mt-2 hidden">
          <p>Vas email postoji u nasoj bazi da li zelite da ga aktivirate ?</p>
          <button class="btn btn-warning">Da</button>
          <button class="btn btn-info">Ne</button>
        </div>
        <div v-if="subexistok" id="postojiemail" class="bg-info mb-2 mt-2 hidden">
          <p>Vas email postoji u nasoj bazi, da se odjavite provjerite svoju email postu i kliknite na link odjavi.</p>
          <button @click="zatvoriInfo();" class="btn btn-warning">OK</button>
        </div>
        <div v-if="subexistnotpay" id="postojiemail" class="bg-info mb-2 mt-2 hidden">
          <p>Vas email postoji u nasoj bazi ali nije izvrsena uplata, ako zelite da uplatite sredstva kliknite "Da" i nastavite sa PayPal placanjem ?</p>
          <button @click="dopuniAccount();" class="btn btn-warning">Da</button>
          <button class="btn btn-info">Ne</button>
        </div>
        <div style="width:50%;margin:auto;" ref="paypal"></div>
      </form>

      <!-- Remind Passowrd -->
      <div id="formFooter" class="bg-dark"></div>
    </div>
  </div>
</template>
<style lang="css" scoped>
@import "././assets/css/demo.css";
</style> 

<script>
export default {
  data: function() {
    return {
      loaded: false,
      subexist: false,
      subexistok: false,
      existId: 0,
      subexistnotpay: false,
      rechargeid: 0,
      paidFor: false,
      email: "",
      emaila: "",
      product: {
        price: 0.5,
        description: "Pretplata za citate .. :)"
      }
    };
  },
  mounted: function() {
    const script = document.createElement("script");
    script.src =
      "https://www.paypal.com/sdk/js?client-id=ARjoU6asWJA3bSFRLGaBdb3lRGZ02QxqIREaaRt7ct-va5NTaog1thDBvE_gGXsQ97pPS9N6MNNKX3V_";
    script.addEventListener("load", this.setLoaded);
    document.body.appendChild(script);
  },
  methods: {
    zatvoriInfo() {
      this.subexist = false;
      this.subexistok = false;
    },
    getFormValues() {
      this.emaila = this.email;
    },
    dopuniAccount() {
      this.rechargeid = this.existId;
      this.subexistnotpay = false;
    },
    paymentProces() {
      this.loaded = true;
      let vm = this;
      window.paypal
        .Buttons({
          onClick: function(data, actions) {
            vm.getFormValues();

            return fetch("api/subscriberbyemail/" + vm.emaila)
              .then(res => res.json())
              .then(res => {
                vm.existId = res.id;
                if (res.id && res.deleted_at) {
                  vm.subexist = true;
                  return actions.reject();
                } else if (
                  res.id &&
                  res.payment == "0" &&
                  vm.rechargeid != res.id
                ) {
                  vm.subexistnotpay = true;
                  return actions.reject();
                }else if (res.id && res.deleted_at == null &&  res.payment == "1") {
                  vm.subexistok = true;
                  return actions.reject();
                }  else {
                  vm.subexist = false;
                  return actions.resolve();
                }
              });
          },
          createOrder: (data, actions) => {
            this.getFormValues();

            return actions.order.create({
              purchase_units: [
                {
                  description: this.product.description,
                  amount: {
                    currency_code: "USD",
                    value: this.product.price
                  }
                }
              ]
            });
          },
          onApprove: async (data, actions) => {
            const order = await actions.order.capture();
            this.data;
            this.paidFor = true;

            let sub = {
              email: this.emaila,
              payment: 1
            };

            this.saveSubscriber(sub);

            console.log(order);
          },
          onCancel: async data => {
            let sub = {
              email: this.emaila,
              payment: 0
            };

            this.saveSubscriber(sub);
            console.log(data);
          },
          onError: err => {
            console.log(err);
          }
        })
        .render(this.$refs.paypal);
    },
    saveSubscriber(data) {
      if (this.rechargeid != 0) {
        data.sub_id = this.rechargeid;
        fetch("api/subscriber", {
          method: "put",
          body: JSON.stringify(data),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(res => {
            this.email = "";
            if (res.updated && this.rechargeid !=0) {
              alert("Uspjesno ste dopunili vas nalog.");
            }
          })
          .catch(err => console.log(err));
        this.rechargeid = 0;
      } else {
        fetch("api/subscriber", {
          method: "post",
          body: JSON.stringify(data),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(res => {
            this.email = "";
            if (data.payment == 0) {
              alert(
                "Odustali ste od uplate, vas mail je upisan u bazu, mozete se naknadno vratiti i izvrsiti uplatu."
              );
            } else {
              alert("Uspjesno ste se registrovali na nas servis.");
            }
          })
          .catch(err => console.log(err));
      }
    },
    setLoaded: function() {
      this.paymentProces();
    }
  }
};
</script>
 
