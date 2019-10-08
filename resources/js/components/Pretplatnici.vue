<template>
  <div>
    <h2>Pretplatnici {{totalc}}</h2>
    
 
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled:!pagination.prev_page_url}]" class="page-item">
          <a @click="fetchPretplanici(pagination.prev_page_url);" class="page-link" href="#">Prethodna</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link">{{pagination.current_page}} od {{pagination.last_page}}</a>
        </li>
        <li v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item">
          <a @click="fetchPretplanici(pagination.next_page_url);" class="page-link" href="#">Sledeca</a>
        </li>
        <li>
          <select name="tippretplate" @change="filterPretplata($event)"    class="form-control">
     <option value="-1">Svi</option>
     <option value="0">Nema pretplate</option>
     <option value="1">Ima pretplatu</option>
</select>
          </li>
      </ul>
    </nav>
    
     <table  class="table" >
       <thead class="thead-dark">
          <tr>
       <th>Email</th>
    
       <th>Datum registovanja</th>
          <th>Pretplata</th>
           <th>Akcije</th>
        </tr>
        </thead>
         <tbody>
    <tr  v-for="pretplanik in pretplanici" v-bind:key="pretplanik.id">
      <td>{{pretplanik.email}}</td>
      <td>{{pretplanik.created_at}}</td>
      <td><span v-if="pretplanik.payment==1" class="badge badge-success">Pretplata</span><span v-else class="badge badge-warning">Nema pretplate</span></td>
       <td><button  @click="changeStatusSubscriber(pretplanik);" v-if="pretplanik.deleted_at" class="btn btn-secondary" data-dismiss="modal">Aktiviraj</button>
              <button  @click="changeStatusSubscriber(pretplanik);" v-if="!pretplanik.deleted_at" class="btn  btn-danger">Deaktiviraj</button></td>
      
     
    </tr>
     </tbody>
     </table>
     
  </div>
</template>
<script>
export default {
  data() {
    return {
      pretplanici: [],
      totalc: 0,
      pretplanik: {
        id: "",
        email: "",
        payment: "",
        payment: "",


      },
      sub_id: "",
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchPretplanici();
  },
  methods: {
    changeStatusSubscriber(pretp)
    {
      
      if(pretp.deleted_at)
      {
        
         fetch('/subscribe/'+pretp.email_token)
        .then()
         
        .catch(err => console.log(err));

      }else
      {
        
         fetch('/unsubscribe/'+pretp.email_token)
        .then()
         
        .catch(err => console.log(err));

      }
 this.fetchPretplanici();
    },
    filterPretplata(event){
 this.fetchPretplanici(this.pagination.current_page_url+'&filter='+event.target.value);
    },
    fetchPretplanici(url_p) {
      let mm = this;
      url_p = url_p || "api/subscribers";
      fetch(url_p)
        .then(res => res.json())
        .then(res => {
          this.pretplanici = res.data;
          mm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(m, l) {
      let pagination = {
        current_page: m.current_page,
        last_page: m.last_page,
        next_page_url: l.next,
        current_page_url: "api/subscribers?page=" + m.current_page,
        prev_page_url: l.prev
      };
      this.totalc = m.total;
      this.pagination = pagination;
    }
   
  }
};
</script>>