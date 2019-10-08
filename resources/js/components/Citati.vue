<template>
  <div>
    <h2>Citati {{totalc}}</h2>
    <button
      type="button"
      class="btn btn-primary mb-3"
      data-toggle="modal"
      data-target="#exampleModal"
    >Dodaj novi citat</button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Dodaj novi citat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="dodajCitat()" class="mb-3">
            <div class="modal-body">
              <div class="form-group">
                <input type="text" v-model="citat.naziv" placeholder="Naziv" class="form-control" />
              </div>
              <div class="form-group">
                <textarea   v-model="citat.text" placeholder="Tekst" class="form-control"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
              <button type="submit" class="btn btn-primary">Snimi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled:!pagination.prev_page_url}]" class="page-item">
          <a @click="fetchCitati(pagination.prev_page_url);" class="page-link" href="#">Prethodna</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link">{{pagination.current_page}} od {{pagination.last_page}}</a>
        </li>
        <li v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item">
          <a @click="fetchCitati(pagination.next_page_url);" class="page-link" href="#">Sledeca</a>
        </li>
      </ul>
    </nav>

    <div class="card card-body mb-2" v-for="citat in citati" v-bind:key="citat.id">
      <h3>{{citat.naziv}}</h3>
      <p>{{citat.text}}</p>
      <div class="col-md-12">
        <button @click="editCitat(citat);" class="btn btn-warning mr-2 mb-2 float-right">Izmjeni</button>

        <button @click="brisiCitat(citat.id);" class="btn btn-danger mr-2 mb-2 float-right">Obriši</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      citati: [],
      totalc: 0,
      citat: {
        id: "",
        naziv: "",
        text: ""
      },
      article_id: "",
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchCitati();
  },
  methods: {
    fetchCitati(url_p) {
      let mm = this;
      url_p = url_p || "api/articles";
      fetch(url_p)
        .then(res => res.json())
        .then(res => {
          this.citati = res.data;
          mm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(m, l) {
      let pagination = {
        current_page: m.current_page,
        last_page: m.last_page,
        next_page_url: l.next,
        current_page_url: "api/articles?page=" + m.current_page,
        prev_page_url: l.prev
      };
      this.totalc = m.total;
      this.pagination = pagination;
    },
    brisiCitat(id) {
      if (confirm("Da li ste sigurni?")) {
        fetch(`api/article/${id}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            alert("Citat obrisan!!");
            this.fetchCitati(this.pagination.current_page_url);
          });
      }
    },
    dodajCitat() {
      if (this.edit === false) {
        fetch("api/article", {
          method: "post",
          body: JSON.stringify(this.citat),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.citat.naziv = "";
            this.citat.text = "";
            $("#exampleModal").modal("hide");

            alert("Uspjesno ste dodali citat");
            this.fetchCitati(this.pagination.current_page_ur);
          })
          .catch(err => console.log(err));
      } else {
        fetch("api/article", {
          method: "put",
          body: JSON.stringify(this.citat),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.citat.naziv = "";
            this.citat.text = "";
            $("#exampleModal").modal("hide");

            alert("Uspjesno ste izmenili citat");
            this.fetchCitati(this.pagination.current_page_ur);
          })
          .catch(err => console.log(err));
      }
    },
    editCitat(citat) {
      this.edit = true;
      this.citat.id = citat.id;
      this.citat.article_id = citat.id;
      this.citat.naziv = citat.naziv;
      this.citat.text = citat.text;
      $("#exampleModal").modal("show");
    }
  }
};
</script>>