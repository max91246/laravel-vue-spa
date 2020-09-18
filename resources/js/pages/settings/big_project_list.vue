<template>
  <card :title="$t('big_project_list')">
    <ul class="list-group">
      <li class="list-group-item" v-for="(value, key) in form.list">
        <router-link :to="'/settings/big_project_update/'+ value.id" class="nav-link" active-class="active">
          {{ value.name }}
        </router-link>
      </li>
    </ul>
      <ul>

      </ul>
  </card>
</template>

<script>
  import Form from 'vform'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      list: []
    })
  }),
  created () {
    this.big_project_list()
  },

  methods: {
    async big_project_list () {
      var data = await this.form.get('/api/big_project/list')
      this.form.list = data.data.data.list
    }
  }
}
</script>
