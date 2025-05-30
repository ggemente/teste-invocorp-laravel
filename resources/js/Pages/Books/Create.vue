<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

const props = defineProps({
    authors: Array,
});

const form = useForm({
    title: '',
    description: '',
    publication_date: '',
    author_id: null,
    cover_image: null,
});

const handleFileChange = (event) => {
    form.cover_image = event.target.files[0];
};

const submit = () => {
    form.post(route('books.store'));
};
</script>

<template>
    <AppLayout title="Novo Livro">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Adicionar Novo Livro</h1>
            <Button variant="outline" asChild>
                <Link :href="route('books.index')">&larr; Voltar para a lista</Link>
            </Button>
        </div>

        <Card class="w-full max-w-2xl mx-auto">
            <CardHeader>
                <CardTitle>Detalhes do Livro</CardTitle>
                <CardDescription>Preencha os campos abaixo para adicionar um novo livro.</CardDescription>
            </CardHeader>
            <form @submit.prevent="submit">
                <CardContent class="space-y-6">
                    <div class="space-y-2">
                        <Label for="title">Título</Label>
                        <Input v-model="form.title" id="title" placeholder="Título do livro" :class="{ 'border-destructive': form.errors.title }" />
                        <p v-if="form.errors.title" class="text-sm text-destructive">{{ form.errors.title }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="description">Descrição</Label>
                        <Textarea v-model="form.description" id="description" placeholder="Descrição detalhada do livro" rows="5" :class="{ 'border-destructive': form.errors.description }" />
                        <p v-if="form.errors.description" class="text-sm text-destructive">{{ form.errors.description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="publication_date">Data de Publicação</Label>
                            <Input type="date" v-model="form.publication_date" id="publication_date" :class="{ 'border-destructive': form.errors.publication_date }" />
                            <p v-if="form.errors.publication_date" class="text-sm text-destructive">{{ form.errors.publication_date }}</p>
                        </div>
                        <div class="space-y-2">
                            <Label for="author_id">Autor</Label>
                            <Select v-model="form.author_id" id="author_id" :class="{ 'border-destructive': form.errors.author_id }">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecione um autor" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="author in authors" :key="author.id" :value="author.id">
                                        {{ author.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="form.errors.author_id" class="text-sm text-destructive">{{ form.errors.author_id }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <Label for="cover_image">Capa do Livro (JPG, PNG - Máx 2MB)</Label>
                        <Input type="file" @change="handleFileChange" id="cover_image" accept="image/jpeg,image/png,image/jpg" :class="{ 'border-destructive': form.errors.cover_image }" />
                        <p v-if="form.errors.cover_image" class="text-sm text-destructive">{{ form.errors.cover_image }}</p>
                    </div>
                </CardContent>
                <CardFooter class="flex justify-end space-x-2">
                    <Button variant="outline" asChild type="button">
                        <Link :href="route('books.index')">Cancelar</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing" :class="{ 'opacity-75': form.processing }">
                        <span v-if="form.processing" class="animate-spin mr-2">⏳</span>
                        Salvar Livro
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AppLayout>
</template>