import NavLink from "@/Components/NavLink";

const NavLinks = ({links}) => {
    return links.map((link, keyId) => {
        const a = link+".index";
        return <NavLink href={route(a)} key={keyId}>{link.cap()}</NavLink>;
    });
}

export default NavLinks;

/*
<NavLink href={route('rental.index')} active={route().current('rental.index')}>
            Rental
        </NavLink>


*/