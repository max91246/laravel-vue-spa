<template>
  <card :title="$t('project_info_create')">
    <form @submit.prevent="submit" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('project_info_success')" />

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品分類名稱</label>
        <div class="col-md-7">
            <select v-model="big_id" class="form-control" >
              <option v-for="option in big_id_option" :value="option.id">{{ option.name }}</option>
            </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品對應內容</label>
        <div class="col-md-7">
          <select v-model="product_id" class="form-control" >
            <option v-for="option in show_project" :value="option.id" >{{ option.name }}</option>
          </select>
        </div>
      </div>

      <div class="form-group row" v-show="step == 0">
        <label class="col-md-3 col-form-label text-md-right">產品size</label>
        <div class="col-md-7 my-2">
          <div class="d-inline custom-control custom-checkbox my-1 mr-sm-2" v-for="option in size">
            <input type="checkbox" class="custom-control-input" :id="'sizeInline' + option.id" :value="option.id" v-model="size_val">
            <label class="custom-control-label" :for="'sizeInline' + option.id" >{{option.name}}</label>
          </div>
        </div>
      </div>
      <div class="form-group row" v-show="step == 0">
        <label class="col-md-3 col-form-label text-md-right">產品樣式</label>
        <div class="col-md-7 my-2">
          <div class="d-inline custom-control custom-checkbox my-1 mr-sm-2" v-for="option in style">
            <input type="checkbox" class="custom-control-input" :id="'styleInline' + option.id" :value="option.id" v-model="style_val">

            <label class="custom-control-label" :for="'styleInline' + option.id" >
              <div class="outsite_div">
                <div class="insite_div" :style="'background:' + option.color + '; '" ></div>
              </div>
            </label>
          </div>
        </div>
      </div>

      <div class="form-group row" v-if="step == 1" v-for="(item , index) in product_info">
        <label class="col-md-3 col-form-label text-md-right">{{size[product_info[index].size_id].name}}-{{style[product_info[index].style_id].name}} 數量</label>
        <div class="col-md-7" >
          <input v-model="product_info[index].num"  class="form-control" type="text" >
        </div>
      </div>
      <!-- Submit Button -->

      <div class="form-group row" v-show="step == 0">
        <div class="col-md-9 ml-md-auto">
          <v-button type="success" >
            {{ $t('next_step') }}
          </v-button>
        </div>
      </div>

      <div class="form-group row" v-show="step == 1">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">
            {{ $t('create') }}
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
  import Form from 'vform'
  import { mapGetters } from 'vuex'
  import axios from 'axios'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  data: () => ({
    data: new Form(),
    form: new Form({}),
    big_id : '',
    product_id:'',
    big_id_option:[],
    product:[],
    show_project : [],
    size : [],
    style : [],
    size_val : [],
    style_val : [],
    step : 0, //挑選步驟
    product_info : [],//產品明細添加
  }),
  watch:{
    big_id(newval,oldval){
      this.get_pro(newval);
    }
  },
  computed: {
    product_date: function () {
      return this.product[this.big_id]
    }
  },
  created () {
    this.get_big_pro()
    this.get_size()
    this.get_style()
  },
  methods: {
    async get_big_pro () {

      await axios({
        method: 'GET',
        url: '/api/big_project/list',
        data: ''
      }).then(res => {
        this.big_id_option = res.data.data.list;
        this.big_id = this.big_id_option[0].id

      }).catch(e => {
        console.log(e)
      })
    },
    get_pro () {
      if (this.product[this.big_id] == undefined){
        axios({
          method: 'POST',
          url: '/api/project/list',
          data: {'big_id' : this.big_id}
        }).then(res => {
          this.product[this.big_id] = res.data.data.list;
          this.show_project = this.product[this.big_id]
          this.product_id = this.show_project[0].id
        }).catch(e => {
          console.log(e)
        })
      }else{
        this.show_project = this.product[this.big_id]
        this.product_id = this.show_project[0].id
      }
    },
    async get_size () {

      await axios({
        method: 'GET',
        url: '/api/size/list',
        data: ''
      }).then(res => {
        this.size = res.data.data.list;

      }).catch(e => {
        console.log(e)
      })
    },
    async get_style () {

      await axios({
        method: 'GET',
        url: '/api/style/list',
        data: ''
      }).then(res => {
        this.style = res.data.data.list;

      }).catch(e => {
        console.log(e)
      })
    },
    async create () {
      //const { data } = await this.form.post('/api/project_info/insert')
    },
    async submit(){
      if (this.step == 0){
        this.step = 1;

        let count = 0;
        for(let i=0; i<this.size_val.length; i++){
          for(let j=0; j<this.style_val.length; j++){
            let data = {};
            data.big_project_id = this.big_id
            data.project_id = this.product_id
            data.size_id = this.size_val[i]
            data.style_id = this.style_val[j]
            data.num = 0
            this.product_info[count] = data;
            count++;
          }

        }
      }else{
        await axios({
          method: 'POST',
          url: '/api/project_info/insert',
          data: this.product_info,
        }).then(res => {
          console.log(res)

        }).catch(e => {
          console.log(e)
        })


      }

    }
  }
}
</script>
