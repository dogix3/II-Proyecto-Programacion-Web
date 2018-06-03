var Navbar = Reactstrap.Navbar;
var NavbarBrand = Reactstrap.NavbarBrand;
var NavbarToggler = Reactstrap.NavbarToggler;
var Collapse = Reactstrap.Collapse;
var Nav = Reactstrap.Nav;
var NavItem = Reactstrap.NavItem;
var NavLink = Reactstrap.NavLink;
var UncontrolledDropdown = Reactstrap.UncontrolledDropdown;
var DropdownToggle = Reactstrap.DropdownToggle;
var DropdownMenu = Reactstrap.DropdownMenu;
var DropdownItem = Reactstrap.DropdownItem;
var Container = Reactstrap.Container;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;

class App extends React.Component {
  constructor(props) {
    super(props)
    this.state = { programas: [], programa: [], revisiones: [], revision: [], usuario: [], is_login: false }
    this.handleReload = this.handleReload.bind(this);
    this.handleChangeData = this.handleChangeData.bind(this);
    this.handleChangePrograma = this.handleChangePrograma.bind(this);
    this.handleChangeRevision = this.handleChangeRevision.bind(this);
    this.checkLogin = this.checkLogin.bind(this);
    this.cerrarSession = this.cerrarSession.bind(this);
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

        this.setState({ revisiones: data });

        this.forceUpdate();

      })

  }
  componentWillMount() {
    if (document.cookie.includes("true")) {
      console.log("Ya el usuario se encuentra logueado segun el cookie");
      this.setState({is_login: true});
    }
    this.handleReload();
  }
  handleChangeData() {
    this.handleReload();
  }
  handleChangePrograma(data) {
    this.setState({ programa: data })
  }
  handleChangeRevision(data) {
    this.setState({ revision: data })
  }
  checkLogin(usuario_2, password_2) {
    fetch("./server/index.php/usuario/"+usuario_2, {

      method: "post",

      headers: {
        'Content-Type': 'application/json',

        'Content-Length': 200
      },

      body: JSON.stringify({

        method: 'confirmUser',

        usuario: usuario_2,

        password: password_2,

      })

    }).then((response) => {
      console.log(response);
      return response.json()

    }).then((data) => {
      console.log(data);
      this.setState({ usuario: data[0] });

      if (this.state.usuario.usuario == usuario_2 && this.state.usuario.password == password_2) {
        this.setState({is_login: true});
        document.cookie = "islogin=true";
      }
    })
    
  }
  cerrarSession(){
    document.cookie = "islogin=false";
    this.setState({is_login: false});
  }
  render() {
    if (this.state.is_login) {
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
                <DropdownItem onClick={this.cerrarSession}>
                  Cerrar Sesión
                  </DropdownItem>
              </DropdownMenu>
            </UncontrolledDropdown>
          </Nav>
        </Collapse>
      </Navbar><Container><Row>
        <Col xs="8"><ProgramasList programas={this.state.programas}
          handleChangePrograma={this.handleChangePrograma} /></Col>
        <Col xs="4"><ProgramasForm programa={this.state.programa}
          handleChangeData={this.handleChangeData} /></Col>
      </Row>
          <Row>
            <Col xs="8"><RevisionesList revisiones={this.state.revisiones}
              programa={this.state.programa}
              handleChangeRevision={this.handleChangeRevision} /></Col>
            <Col xs="4"><RevisionesForm revision={this.state.revision}
              programa={this.state.programa}
              handleChangeData={this.handleChangeData} /></Col>
          </Row></Container></div>)
    } else {
      return (
        <LoginForm checkLogin={this.checkLogin} />
      )
    }
  }
}
ReactDOM.render(<App />, document.getElementById('root'));