<template>
  <card :title="$t('big_project_update')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('big_project_update_success')" />

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">產品分類名稱</label>
        <div class="col-md-7">
          <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name" />
        </div>
      </div>


      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">
            {{ $t('update') }}
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
  import Form from 'vform'
  import axios from 'axios'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      id: '',
      name: ''
    }),
    data: new Form({
      id  : ''
    })
  }),
  created () {
    this.big_project_one()
  },

  methods: {
    async big_project_one () {
      this.data.id = this.$route.params.id;
      var data = await this.data.post('/api/big_project/list')
      this.form.id = data.data.data.list.id
      this.form.name = data.data.data.list.name
    },
    async update () {
      const { data } = await this.form.post('/api/big_project/update')

    }
  }
}
</script>
