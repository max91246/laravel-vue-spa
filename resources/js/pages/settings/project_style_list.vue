<template>
  <card :title="$t('project_style_list')">
    <ul class="list-group">
      <li class="list-group-item" v-for="(value, key) in form.list">
        <router-link :to="'/settings/project_style_update/'+ value.id" class="nav-link" active-class="active">
          {{ value.name }}<div :style="'background:' + value.color + '; width: 20px;height: 20px;display: inline-block;margin-left: 10px;'" ></div>
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
      var data = await this.form.get('/api/style/list')
      this.form.list = data.data.data.list
    }
  }
}
</script>
