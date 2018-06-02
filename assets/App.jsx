var Navbar = Reactstrap.Navbar;
var NavbarBrand = Reactstrap.NavbarBrand;
var NavbarToggler = Reactstrap.NavbarToggler;
var Collapse = Reactstrap.Collapse;
var Nav = Reactstrap.Nav;
var NavItem = Reactstrap.NavItem;
var NavLink = Reactstrap.NavLink;
var UncontrolledDropdown = Reactstrap.UncontrolledDropdown;
var DropdownToggle =  Reactstrap.DropdownToggle;
var DropdownMenu = Reactstrap.DropdownMenu;
var DropdownItem = Reactstrap.DropdownItem;
var Container = Reactstrap.Container;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;
var Modal = Reactstrap.Modal;
var ModalHeader = Reactstrap.ModalHeader;
var ModalBody = Reactstrap.ModalBody;
var ModalFooter = Reactstrap.ModalFooter;

class App extends React.Component {
    constructor(props) {
        super(props)
        this.state = { countries: [], country: [], options: [], modal: false, nuevo:false }
        this.handleReload = this.handleReload.bind(this);
        this.handleEditData = this.handleEditData.bind(this);
        this.handleChangeData = this.handleChangeData.bind(this);
        this.handleChangeCountry = this.handleChangeCountry.bind(this);
        this.handleAddData = this.handleAddData.bind(this);
    }
    handleReload() {
        fetch('./server/index.php/country')
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            this.setState({ countries: data });
            this.forceUpdate();
        })
    }
    componentWillMount() {
        this.handleReload();
    }
    handleChangeData() {
        this.handleReload();
    }
    handleChangeCountry(data) {
        this.setState({country: data})
    }
    handleEditData(bool) {
    	if (bool) {
    		this.setState({
     		 nuevo: true
    		});
    	}else{
    		this.setState({
     		 nuevo: false
    		});
    	}
        this.setState({
      modal: !this.state.modal
    });
    }
    handleAddData() {
        this.setState({
      nuevo: true
    });
    }
    render() {
        return (<div><Navbar color="light" light expand="md">
          <NavbarBrand href="/">Datos de Países</NavbarBrand>
          <NavbarToggler onClick={this.toggle} />
        </Navbar><p></p><Container><Row>
        <Col xs="8"><CountryList countries={this.state.countries}
        	handleEditData={this.handleEditData}
        	handleAddData={this.handleAddData}
            handleChangeCountry={this.handleChangeCountry}/></Col>
        <Col xs="4"><CountryDisplay country={this.state.country}
            handleEditData={this.handleEditData}/></Col>
        </Row>
        </Container>
        <CountryForm country={this.state.country} modal={this.state.modal}
            handleEditData={this.handleEditData}
            nuevo={this.state.nuevo}
            handleChangeData={this.handleChangeData}/>
        </div>)
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));