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

class App extends React.Component {
    constructor(props) {
        super(props)
        this.state = { programas: [], factura: [], productos: [], producto: []  }
        this.handleReload = this.handleReload.bind(this);
        this.handleChangeData = this.handleChangeData.bind(this);
        this.handleChangeFactura = this.handleChangeFactura.bind(this);
        this.handleChangeProducto = this.handleChangeProducto.bind(this);
    }
    handleReload() {

         fetch('./server/index.php/programa')

           .then((response) => {

               return response.json()

           })

           .then((data) => {

               this.setState({ programas: data });

               this.forceUpdate();

           })



           fetch('./server/index.php/revision')

           .then((response) => {

               return response.json()

           })

           .then((data) => {

               this.setState({ productos: data });

               this.forceUpdate();

           })

       }
    componentWillMount() {
        this.handleReload();
    }
    handleChangeData() {
        this.handleReload();
    }
    handleChangeFactura(data) {
      this.setState({factura: data})
    }
    handleChangeProducto(data) {
      this.setState({producto: data})
    }
    render() {
        return (<div><Navbar color="light" light expand="md">
          <NavbarBrand href="/">Datos de Facturas</NavbarBrand>
          <NavbarToggler onClick={this.toggle} />
          <Collapse isOpen={this.state.isOpen} navbar>
            <Nav className="ml-auto" navbar>
              <NavItem>
                <NavLink href="http://programacion-con-reactjs.readthedocs.io">Tutorial</NavLink>
              </NavItem>
              <UncontrolledDropdown nav inNavbar>
                <DropdownToggle nav caret>
                  Options
                </DropdownToggle>
                <DropdownMenu right>
                  <DropdownItem>
                    Option 1
                  </DropdownItem>
                  <DropdownItem>
                    Option 2
                  </DropdownItem>
                  <DropdownItem divider />
                  <DropdownItem>
                    Reset
                  </DropdownItem>
                </DropdownMenu>
              </UncontrolledDropdown>
            </Nav>
          </Collapse>
        </Navbar><Container><Row>
        <Col xs="8"><ProgramasList programas={this.state.programas} 
                 handleChangeFactura={this.handleChangeFactura}/></Col>
        <Col xs="4"><ProgramasForm factura={this.state.factura}
                 handleChangeData={this.handleChangeData}/></Col>
        </Row>
        <Row>
        <Col xs="8"><RevisionesList productos={this.state.productos} 
                factura={this.state.factura}
                 handleChangeProducto={this.handleChangeProducto}/></Col>
        <Col xs="4"><RevisionesForm producto={this.state.producto}
                 handleChangeData={this.handleChangeData}/></Col>
        </Row></Container></div>)
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));