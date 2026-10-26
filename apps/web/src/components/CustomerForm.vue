<template>
  <q-form class="q-gutter-y-md">
    <q-input
      outlined
      stack-label
      required
      label="Nome"
      v-model="customer.name"
    />
    <q-input
      v-model="customer.email"
      label="E-mail"
      type="email"
      placeholder="Digite seu e-mail"
      outlined
      required
    />
    <q-input
      v-model="customer.birthdate"
      label="Data de nascimento"
      type="date"
      outlined
      required
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
</script>