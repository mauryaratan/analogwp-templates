import styled from "styled-components";
import AnalogContext from "./AnalogContext";
import Logo from "./icons/logo";

const Container = styled.div`
	background: #fff;
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 12px 24px;

	svg {
		vertical-align: bottom;
	}

	a {
		color: #060606;
		text-transform: uppercase;
		font-size: 12px;
		font-weight: bold;
		text-decoration: none;
		&:first-of-type {
			margin-left: auto;
		}
		+ a {
			position: relative;
			margin-left: 30px;
			&:before {
				content: "";
				background: #d4d4d4;
				width: 2px;
				height: 25px;
				position: absolute;
				display: block;
				left: -16px;
				top: -4px;
			}
		}
	}
`;

const Header = () => (
	<Container>
		<Logo />
		<AnalogContext.Consumer>
			{context => (
				<a
					href="#"
					onClick={e => {
						e.preventDefault();
						context.forceRefresh();
					}}
				>
					{context.state.syncing ? "Syncing..." : "Sync Library"}
				</a>
			)}
		</AnalogContext.Consumer>
		{!AGWP.is_settings_page && <a href="#">Close</a>}
	</Container>
);

export default Header;
