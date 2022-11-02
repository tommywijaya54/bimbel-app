import React from 'react';
import { Link, usePage } from '@inertiajs/inertia-react';

export default function TopNavigationList() {
    const excludeFromTopNavList = ['user', 'branch', 'role', 'employee']; // for admin
    let navlist = usePage().props.auth.permissions.filter((alist) => {
        return alist.includes('list-') && (!excludeFromTopNavList.includes(alist.split('-')[1]));
    });

    const Nav = ({href,children}) => {
        return <a
            href={href}
            className='inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
            >
            {children}
        </a>
    }

    const NavList = ({list}) => {
        return <>
        <Nav href='/chat'>Chat</Nav>
        <Nav href='/timetable'>Timetable</Nav>
        <Nav href='/attendance'>Attendance</Nav>
        {
            list.map(((listonly,i) => {
                const model = listonly.split("list-")[1];
                const href = "/"+model.replaceAll(" ",'-');
                return <Link
                            key={i}
                            href={href}
                            className = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                            >
                            {model.cap()}
                        </Link>
            }))
        }
        </>
    }

    return <>
        <NavList list={navlist}></NavList>
    </>;
}
