import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import List from '@/Shared/DisplayPageComponent/List/List';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <List 
                {...props.list}
            ></List>
        </MainLayout>
    );
}