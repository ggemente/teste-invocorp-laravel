<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

const props = defineProps({
    author: Object,
});

const form = useForm({
    name: props.author.name,
    status: props.author.status,
});

const submit = () => {
    form.put(route('authors.update', props.author.id));
};
</script>

<template>
    <AppLayout :title="`Editar Autor: ${author.name}`">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Editar Autor</h1>
            <Button variant="outline" asChild>
                <Link :href="route('authors.index')">&larr; Voltar para a lista</Link>
            </Button>
        </div>

        <Card class="w-full max-w-2xl mx-auto">
            <CardHeader>
                <CardTitle>{{ author.name }}</CardTitle>
                <CardDescription>Atualize os detalhes do autor abaixo.</CardDescription>
            </CardHeader>
            <form @submit.prevent="submit">
                <CardContent class="space-y-6">
                    <div class="space-y-2">
                        <Label for="name">Nome</Label>
                        <Input v-model="form.name" id="name" :class="{ 'border-destructive': form.errors.name }" />
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
                        Atualizar Autor
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AppLayout>
</template>