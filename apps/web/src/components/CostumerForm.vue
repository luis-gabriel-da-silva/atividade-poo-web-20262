<template>
  <q-form class="q-gutter-y-md">
    <q-toggle
      v-model="customer.enabled"
      :label="`Cliente ${customer.enabled ? 'ativo' : 'inativo'}`"
    />
    <q-input
      outlined
      stack-label
      required
      label="Nome"
      v-model="customer.name"
    />
    <q-input
      outlined
      stack-label
      type="email"
      label="E-mail"
      v-model="customer.email"
    />
    <div class="row q-col-gutter-md">
      <div class="col-12 col-sm-6">
        <q-input
          outlined
          stack-label
          label="Telefone"
          mask="(##) #####-####"
          unmasked-value
          v-model="customer.phone"
        />
      </div>
      <div class="col-12 col-sm-6">
        <q-input
          outlined
          stack-label
          label="CPF/CNPJ"
          :mask="documentMask"
          unmasked-value
          v-model="customer.document"
        />
      </div>
    </div>
    <q-input
      outlined
      stack-label
      autogrow
      label="Endereço"
      v-model="customer.address"
    />
    <q-input
      outlined
      stack-label
      autogrow
      label="Observações"
      v-model="customer.notes"
    />
    <div class="full-width bg-grey-1 q-py-md">
      <q-btn-group spread flat>
        <q-btn
          flat
          no-caps
          :loading="customer.saving"
          type="submit"
          label="Salvar"
          icon="save"
          color="positive"
        />
      </q-btn-group>
    </div>
  </q-form>
</template>

<script setup>
import { computed } from 'vue';

const customer = defineModel({
  default: () => ({
    id: null,
    enabled: true,
    name: null,
    email: null,
    phone: null,
    document: null,
    address: null,
    notes: null,
    saving: false,
  }),
})

// Máscara dinâmica: CPF (11 dígitos) ou CNPJ (14 dígitos)
const documentMask = computed(() => {
  const digits = (customer.value?.document ?? '').replace(/\D/g, '')
  return digits.length > 11 ? '##.###.###/####-##' : '###.###.###-##'
})
</script>