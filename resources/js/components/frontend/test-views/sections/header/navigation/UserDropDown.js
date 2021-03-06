import React,{Fragment} from "react";
import {NavLink} from "react-router-dom";
import NavItem from "./NavItem";
import DropdownNavItem from "./DropdownNavItem";

const UserDropDown = (props) => {
	
	
	return (
		<Fragment>
			<ul className="navbar-nav navbar-nav-hover m-auto">
				<NavItem link={"/"} name={"Home"}/>
				<NavItem link={"/about"} name={"About"}/>
				<NavItem link={"/study-materials"} name={"Study Materials"}>
					<DropdownNavItem
						link={"/study-materials/books"}
						name={"Books"}
						icon={"fas fa-book"}
						info={"Access Books to Boost Academic Performance"}
						color={"secondary"}
					/>
					<DropdownNavItem
						link={"/study-materials/Blog"}
						name={"Blog & Articles"}
						icon={"fas fa-blog"}
						info={"Read our blog and articles"}
						color={"danger"}
					/>
				</NavItem>
				
				
			</ul>
		</Fragment>
	);
}