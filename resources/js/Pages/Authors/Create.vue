<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

const form = useForm({
    name: '',
    status: 'active',
});

const submit = () => {
    form.post(route('authors.store'));
};
</script>

<template>
    <AppLayout title="Novo Autor">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Adicionar Novo Autor</h1>
            <Button variant="outline" asChild>
                <Link :href="route('authors.index')">&larr; Voltar para a lista</Link>
            </Button>
        </div>

        <Card class="w-full max-w-2xl mx-auto">
            <CardHeader>
                <CardTitle>Detalhes do Autor</CardTitle>
                <CardDescription>Preencha os campos abaixo para adicionar um novo autor.</CardDescription>
            </CardHeader>
            <form @submit.prevent="submit">
                <CardContent class="space-y-6">
                    <div class="space-y-2">
                        <Label for="name">Nome</Label>
                        <Input v-model="form.name" id="name" placeholder="Nome completo do autor" :class="{ 'border-destructive': form.errors.name }" />
                        <p v-if="form.errors.name" class="text-sm text-destructive">{{ form.errors.name }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="status">Status</Label>
                        <Select v-model="form.status" id="status" :class="{ 'border-destructive': form.errors.status }">
                            <SelectTrigger>
                                <SelectValue placeholder="Selecione um status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="active">Ativo</SelectItem>
                                <SelectItem value="inactive">Inativo</SelectItem>
                            </SelectContent>
                        </Select>
                        <p v-if="form.errors.status" class="text-sm text-destructive">{{ form.errors.status }}</p>
                    </div>
                </CardContent>
                <CardFooter class="flex justify-end space-x-2">
                    <Button variant="outline" asChild type="button">
                        <Link :href="route('authors.index')">Cancelar</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing" :class="{ 'opacity-75': form.processing }">
                        <span v-if="form.processing" class="animate-spin mr-2">⏳</span>
                        Salvar Autor
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AppLayout>
</template>