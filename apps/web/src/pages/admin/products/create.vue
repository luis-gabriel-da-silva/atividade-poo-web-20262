<template>
  <q-page padding>
    <q-card>
      <q-card-actions>
        <q-btn
          flat
          no-caps
          icon="arrow_back"
          to="/admin/products"
          label="Cadastrar produto"
        />
      </q-card-actions>
      <q-card-section>
        <product-form
          v-model="product"
          :loading="saving"
          @submit="saveProduct"
        />
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import ProductForm from '@/components/ProductForm.vue'
import { ref } from 'vue'
import { createProduct } from './_api'
import { Notify } from 'quasar'
import { useRouter } from 'vue-router'

const router = useRouter()
const saving = ref(false)

const product = ref({
  enabled: true,
  name: '',
  description: '',
  price: 0,
  stock: 0,
})

const saveProduct = async () => {
  saving.value = true
  try {
    const data = await createProduct(product.value)
    console.log('resposta:', data) // confira se tem o id aqui
    Notify.create({ type: 'positive', message: 'Produto cadastrado!' })
    router.push(`/admin/products/${data.id}`)
  } catch (error) {
    console.error(error)
    Notify.create({
      type: 'negative',
      message: error?.response?.data?.message || 'Erro ao cadastrar produto',
    })
  } finally {
    saving.value = false
  }
}
</script>